<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\Traits\HasFields;
use Illuminate\Http\Request;

final class Panel extends Field
{
    use HasFields;

    public const FIELD_TYPE = 'panel';

    protected string $component = 'fk-admin-field-panel';

    public function getRules(): array
    {
        return collect($this->fields)
                ->reduce(function (array $fields, FieldInterface $field) {
                    return array_merge($fields, $field->getRules());
                }, []);
    }

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['fields'] = $this->getFields($request);

        return $data;
    }
}
