<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields\Relationships;

use FluentKit\Admin\UI\Actions\CallbackAction;
use FluentKit\Admin\UI\Actions\ModalAction;
use FluentKit\Admin\UI\Actions\ModalCloseAction;
use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\Fields\Field;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class HasMany extends Field
{
    use HasModel;

    protected array $indexFields = [];

    protected array $createFields = [];

    protected array $editFields = [];

    public function __construct(string $id, string $label, string $description = '')
    {
        $this->setModel($label);
        parent::__construct($id, $this->getModelPluralLabel(), $description);

        $this->addAction(
            (new ModalAction('create', 'Add New'))
                ->setMeta('modal.title', 'Create ' . $this->getLabel())
                ->setMeta('modal.size', 'lg')
                ->addAction(new ModalCloseAction('cancel', 'Cancel'))
                ->addAction(
                    (new CallbackAction('validate', 'Save'))
                        ->setMeta('button.type', 'info')
                        ->callback([$this, 'validateModel'])
                )
        );

        $this->addAction(
            (new ModalAction('edit', ''))
                ->setMeta('modal.title', 'Edit ' . $this->getLabel())
                ->setMeta('modal.size', 'lg')
                ->addAction(new ModalCloseAction('cancel', 'Cancel'))
                ->addAction(
                    (new CallbackAction('validate', 'Save'))
                        ->setMeta('button.type', 'info')
                        ->callback([$this, 'validateModel'])
                )
        );
    }

    public function indexFields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->indexFields[$field->getId()] = $field->readOnly();
        }

        return $this;
    }

    public function createFields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->createFields[$field->getId()] = $field->layout('stacked');
        }

        return $this;
    }

    public function editFields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->editFields[$field->getId()] = $field->layout('stacked');
        }

        return $this;
    }

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['indexFields'] = collect($this->indexFields)
            ->map(fn (FieldInterface $field) => $field->toArray($request))
            ->sortBy('priority')
            ->toArray();

        $data['createFields'] = collect($this->createFields)
            ->map(fn (FieldInterface $field) => $field->toArray($request))
            ->sortBy('priority')
            ->toArray();

        $data['editFields'] = collect($this->editFields)
            ->map(fn (FieldInterface $field) => $field->toArray($request))
            ->sortBy('priority')
            ->toArray();

        return $data;
    }

    public function saveAttributes(Model $model, Request $request): Model
    {
        $requestModels = $request->input('attributes.'.$this->getId());
        $models = $model->{$this->getId()};
        $newRelations = [];

        foreach ($requestModels as $key => $requestModel) {
            if (isset($requestModel['__fk_delete']) && $requestModel['__fk_delete'] === true) {
                $models->find($requestModel['id'])->delete();
                unset($models[$key]);
            } elseif (isset($requestModel['__fk_modified']) && $requestModel['__fk_modified'] === true) {
                $relatedModel = $models->find($requestModel['id']);
                $relationRequest = $request->duplicate();
                $relationRequest->merge(['attributes' => $requestModel]);
                foreach ($this->editFields as $field) {
                    $relatedModel = $field->saveAttributes($relatedModel, $relationRequest);
                }
            } elseif (isset($requestModel['__fk_new']) && $requestModel['__fk_new'] === true) {
                $relatedModel = call_user_func([$model, $this->getId()])->make([]);
                $relationRequest = $request->duplicate();
                $relationRequest->merge(['attributes' => $requestModel]);
                foreach ($this->createFields as $field) {
                    $relatedModel = $field->saveAttributes($relatedModel, $relationRequest);
                }
                $newRelations[] = $relatedModel;
            }
        }

        foreach ($newRelations as $relation) {
            $models->push($relation);
        }

        return $model;
    }

    public function validateModel(Request $request, ScreenInterface $screen): ResponseInterface
    {
        $validator = Validator::make($request->get('attributes'), [], []);

        foreach ($this->editFields as $field) {
            $validator = $field->addValidationLabels($validator, $request, $screen);
            $validator = $field->addValidationRules($validator, $request, $screen);
        }

        $validator->validate();

        return Notification::info($this->getModelLabel() . ' Validated.');
    }
}
