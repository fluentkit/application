<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

use FluentKit\Admin\UI\FieldInterface;
use Illuminate\Http\Request;

trait HasFields
{
    protected array $fields = [];

    public function addField(FieldInterface $field): self
    {
        $this->fields[$field->getId()] = $field;

        return $this;
    }

    public function getField(string $id): ?FieldInterface
    {
        return $this->fields[$id] ?? null;
    }

    public function getFields(Request $request): array
    {
        return collect($this->fields)
            ->map(fn (FieldInterface $field) => $field->toArray($request))
            ->sortBy('priority')
            ->toArray();
    }

    public function getFieldRules(array $parentRules = []): array
    {
        return collect($this->fields)
            ->reduce(function (array $fields, FieldInterface $field) {
                return array_merge($fields, $field->getRules());
            }, []);
    }

    public function getFieldLabels(): array
    {
        return collect($this->fields)
            ->reduce(function (array $fields, FieldInterface $field) {
                if (method_exists($field, 'getFieldLabels')) {
                    $labels = $field->getFieldLabels();
                } else {
                    $labels = [$field->getId() => $field->getLabel()];
                }

                return array_merge($fields, $labels);
            }, []);
    }
}
