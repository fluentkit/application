<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields\Relationships;

use FluentKit\Admin\UI\Fields\Field;
use FluentKit\Admin\UI\Traits\HasFields;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Http\Request;

final class HasMany extends Field
{
    use HasFields, HasModel;

    public function __construct(string $id, string $label, string $description = '')
    {
        $this->setModel($label);
        parent::__construct($id, $this->getModelPluralLabel(), $description);
    }

    public function indexFields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->addField($field->readOnly()->setMeta('hasMany.showOnIndex', true));
        }

        return $this;
    }

    public function createFields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->addField($field->readOnly()->setMeta('hasMany.showOnCreate', true));
        }

        return $this;
    }

    public function editFields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->addField($field->readOnly()->setMeta('hasMany.showOnEdit', true));
        }

        return $this;
    }

    public function getRules(): array
    {
        return $this->getFieldRules();
    }

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['fields'] = $this->getFields($request);

        return $data;
    }
}
