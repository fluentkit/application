<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Traits\HasFields;
use Illuminate\Http\Request;

final class HasMany extends Field
{
    use HasFields;

    public const FIELD_TYPE = 'has-many';

    protected string $component = 'fk-admin-field-has-many';

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
