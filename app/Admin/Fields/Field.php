<?php

declare(strict_types=1);

namespace FluentKit\Admin\Fields;

use FluentKit\Admin\FieldInterface;
use Illuminate\Http\Request;

abstract class Field implements FieldInterface
{
    protected ?string $id;

    protected ?string $label;

    protected ?string $description;

    protected $requiredCallback;

    protected array $rules = [];

    protected array $defaultRules = [];

    public function __construct(string $id, string $label, string $description = '')
    {
        $this->id = $id;
        $this->label = $label;
        $this->description = $description;

        $this->requiredCallback = fn (Request $request) => false;
    }

    public function rules(array $rules): FieldInterface
    {
        $this->rules = $rules;

        return $this;
    }

    public function required(callable $callback): FieldInterface
    {
        $this->requiredCallback = $callback;

        return $this;
    }

    public function getRules(): array
    {
        return [$this->getId() => array_unique(array_merge($this->rules, $this->defaultRules))];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function toArray(Request $request): array
    {
        $rules = $this->getRules()[$this->getId()] ?? [];

        return [
            'id' => $this->getId(),
            'label' => $this->label,
            'required' => in_array('required', $rules) || call_user_func($this->requiredCallback, $request),
            'type' => static::FIELD_TYPE,
            'description' => $this->description,
        ];
    }

}
