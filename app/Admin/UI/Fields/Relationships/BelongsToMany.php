<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields\Relationships;

use FluentKit\Admin\UI\Actions\CallbackAction;
use FluentKit\Admin\UI\Actions\ModalAction;
use FluentKit\Admin\UI\Actions\ModalCloseAction;
use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\Fields\Field;
use FluentKit\Admin\UI\Fields\Select;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

final class BelongsToMany extends Field
{
    use HasModel;

    protected array $indexFields = [];

    protected array $attachFields = [];

    public function __construct(string $id, string $label, string $description = '')
    {
        $this->setModel($label);
        parent::__construct($id, $this->getModelPluralLabel(), $description);

        $this->addAction(
            (new ModalAction('attach', 'Attach ' . $this->getModelLabel()))
                ->setMeta('modal.title', 'Attach ' . $this->getModelLabel())
                ->setMeta('modal.size', 'sm')
                ->addAction(new ModalCloseAction('cancel', 'Cancel'))
                ->addAction(
                    (new CallbackAction('attach', 'Attach ' . $this->getModelLabel()))
                        ->setMeta('button.type', 'info')
                        ->callback([$this, 'attachModel'])
                )
        );

        $this->attachFields['id'] = (new Select('id', $this->getModelLabel()))
            ->options(new Select\OptionsForModel($this->getModel(), 'id'))
            ->layout('stacked');
    }

    public function indexFields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->indexFields[$field->getId()] = $field->readOnly();
        }

        return $this;
    }

    public function labelFrom(string $from): self
    {
        $this->attachFields['id']->options(new Select\OptionsForModel($this->getModel(), $from));

        return $this;
    }

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['indexFields'] = collect($this->indexFields)
            ->map(fn (FieldInterface $field) => $field->toArray($request))
            ->sortBy('priority')
            ->toArray();

        $data['attachFields'] = collect($this->attachFields)
            ->map(fn (FieldInterface $field) => $field->toArray($request))
            ->sortBy('priority')
            ->toArray();

        return $data;
    }

    public function saveAttributes(Model $model, Request $request): Model
    {
        $model::saved(function (Model $model) use ($request) {
            $ids = collect($request->input('attributes.'.$this->getId()))
                ->reject(fn ($attached) => $attached['__fk_delete'] ?? false)
                ->pluck('id');
            call_user_func([$model, $this->getId()])->sync($ids);
        });

        return $model;
    }

    public function attachModel(Request $request, ScreenInterface $screen): ResponseInterface
    {
        $attributes = $request->get('attributes');
        return Notification::info($this->getModelLabel() . ' Attached.')
            ->setMeta('attached', $this->newModelQuery()->find((int) $attributes['id']));
    }
}
