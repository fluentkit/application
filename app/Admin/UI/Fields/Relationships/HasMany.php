<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields\Relationships;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\Fields\Field;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Http\Request;

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
            $this->createFields[$field->getId()] = $field;
        }

        return $this;
    }

    public function editFields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->editFields[$field->getId()] = $field;
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
}
