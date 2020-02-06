<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields\Relationships;

use FluentKit\Admin\UI\Fields\Field;
use FluentKit\Admin\UI\Fields\Route;
use FluentKit\Admin\UI\Fields\Select;
use FluentKit\Admin\UI\Traits\HasFields;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class BelongsTo extends Field
{
    use HasFields, HasModel;

    public const FIELD_TYPE = 'belongs-to';

    protected string $component = 'fk-admin-field-belongs-to';

    public function __construct(string $id, string $label, string $description = '')
    {
        $this->setModel($label);
        parent::__construct($id, $this->getModelLabel(), $description);
        $this->addField(
            (new Route('route', $label, $description))
                ->route(Str::plural($id).'.edit')
                ->routeLabelFrom($this->getId().'.'.'id')
        );
        $this->addField(
            (new Select('input', $this->getModelLabel()))
                ->options(new Select\OptionsForModel($this->getModel(), 'id'))
        );
    }

    public function route(string $route): self
    {
        $this->getField('route')->route($route);

        return $this;
    }

    public function labelFrom(string $from): self
    {
        $this->getField('route')->routeLabelFrom($this->getId().'.'.$from);
        $this->getField('input')->options(new Select\OptionsForModel($this->getModel(), $from));

        return $this;
    }

    public function getRules(): array
    {
        return [$this->getId().'.id' => array_unique(array_merge($this->rules, $this->defaultRules))];
    }

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['fields'] = $this->getFields($request);
        // fix required as we actually use the sub key `id` for the rules
        $data['required'] = in_array('required', $this->rules) || call_user_func($this->requiredCallback, $request);

        return $data;
    }

    public function saveAttributes(Model $model, Request $request): Model
    {
        $relationId = $request->input('attributes.'.$this->getId().'.id');
        $relationship = call_user_func([$model, $this->getId()]);

        if (!$relationId) {
            $relationship->dissociate();
        } else {
            $relationship->associate((int) $relationId);
        }

        return $model;
    }
}
