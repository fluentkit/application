<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\CanBeDisabled;
use FluentKit\Admin\UI\Traits\CanBeHidden;
use FluentKit\Admin\UI\Traits\CanBeReadOnly;
use FluentKit\Admin\UI\Traits\HasId;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasMeta;
use FluentKit\Admin\UI\Traits\HasPriority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

abstract class Field implements FieldInterface
{
    use HasId, HasLabel, HasPriority, CanBeDisabled, CanBeReadOnly, CanBeHidden, HasMeta;

    protected ?string $description;

    protected string $layout = 'left';

    protected string $align = 'left';

    protected ?string $component = null;

    protected $requiredCallback;

    protected array $rules = [];

    protected array $defaultRules = [];

    protected array $meta = [];

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

    public function align(string $align): FieldInterface
    {
        $this->align = $align;

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

    public function getAlign(): string
    {
        return $this->align;
    }

    public function getRules(): array
    {
        return array_unique(array_merge($this->rules, $this->defaultRules));
    }

    public function toArray(Request $request): array
    {
        $type = str_replace('_', '-', Str::snake(class_basename(get_called_class())));

        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'label' => $this->getLabel(),
            'layout' => $this->getLayout(),
            'align' => $this->getAlign(),
            'required' => in_array('required', $this->getRules()) || call_user_func($this->requiredCallback, $request),
            'disabled' => $this->getDisabled($request),
            'readOnly' => $this->getReadOnly($request),
            'hidden' => $this->getHidden($request),
            'type' => $type,
            'description' => $this->description,
            'component' => $this->component ?? 'fk-admin-field-' . $type,
            'meta' => $this->getMeta(),
        ];
    }

    public function addValidationLabels(Validator $validator, Request $request, ScreenInterface $screen): Validator
    {
        $validator->addCustomAttributes([
            $this->getId() => $this->getLabel()
        ]);

        return $validator;
    }

    public function addValidationRules(Validator $validator, Request $request, ScreenInterface $screen): Validator
    {
        $validator->addRules([
            $this->getId() => $this->replaceValidationPatterns($request, $this->getRules())
        ]);

        return $validator;
    }

    protected function replaceValidationPatterns(Request $request, array $rules): array
    {
        return collect($rules)->map(function ($rule) use ($request) {
            return str_replace('{$id}', $request->get('id'), (string) $rule);
        })->toArray();
    }

    public function saveAttributes(Model $model, Request $request): Model
    {
        // Nothing to do here
        return $model;
    }
}
