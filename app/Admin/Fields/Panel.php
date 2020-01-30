<?php

declare(strict_types=1);

namespace FluentKit\Admin\Fields;

use FluentKit\Admin\FieldInterface;
use Illuminate\Http\Request;

final class Panel extends Field
{
    public const FIELD_TYPE = 'panel';

    protected array $fields = [];

    public function addField(FieldInterface $field): FieldInterface
    {
        $this->fields[$field->getId()] = $field;

        return $this;
    }

    public function getRules(): array
    {
        return collect($this->fields)
                ->reduce(function (array $fields, FieldInterface $field) {
                    return array_merge($fields, $field->getRules());
                }, []);
    }

    public function toArray(Request $request): array
    {
        $field = parent::toArray($request);
        $field['fields'] = collect($this->fields)
                            ->map(fn (FieldInterface $field) => $field->toArray($request))
                            ->toArray();

        return $field;
    }
}
