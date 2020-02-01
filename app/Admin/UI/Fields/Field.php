<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\Traits\CanBeDisabled;
use FluentKit\Admin\UI\Traits\CanBeHidden;
use FluentKit\Admin\UI\Traits\CanBeReadOnly;
use FluentKit\Admin\UI\Traits\HasId;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasPriority;
use Illuminate\Http\Request;

abstract class Field implements FieldInterface
{
    use HasId, HasLabel, HasPriority, CanBeDisabled, CanBeReadOnly, CanBeHidden;

    protected ?string $description;

    protected string $layout = 'left';

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

    public function layout(string $layout): FieldInterface
    {
        $this->layout = $layout;

        return $this;
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

    public function getLayout(): string
    {
        return $this->layout;
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
            'layout' => $this->getLayout(),
            'required' => in_array('required', $rules) || call_user_func($this->requiredCallback, $request),
            'disabled' => $this->getDisabled($request),
            'readOnly' => $this->getReadOnly($request),
            'hidden' => $this->getHidden($request),
            'type' => static::FIELD_TYPE,
            'description' => $this->description,
            'component' => $this->component,
        ];
    }

}
