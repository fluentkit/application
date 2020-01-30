<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\Traits\HasId;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasPriority;
use Illuminate\Http\Request;

abstract class Field implements FieldInterface
{
    use HasId, HasLabel, HasPriority;

    protected ?string $description;

    protected bool $providesOwnLayout = false;

    protected string $component = 'fk-admin-field-input';

    protected $requiredCallback;

    protected array $rules = [];

    protected array $defaultRules = [];

    public function __construct(string $id, string $label, string $description = '')
    {
        $this->setId($id);
        $this->setLabel($label);

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

    public function toArray(Request $request): array
    {
        $rules = $this->getRules()[$this->getId()] ?? [];

        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'label' => $this->getLabel(),
            'required' => in_array('required', $rules) || call_user_func($this->requiredCallback, $request),
            'type' => static::FIELD_TYPE,
            'description' => $this->description,
            'providesOwnLayout' => $this->providesOwnLayout,
            'component' => $this->component,
        ];
    }

}
