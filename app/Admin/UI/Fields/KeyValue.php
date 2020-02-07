<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Fields\Traits\SavesModelAttributes;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

final class KeyValue extends Field
{
    use SavesModelAttributes;

    protected string $keyLabel = 'Key';

    protected string $valueLabel = 'Label';

    protected string $addLabel = 'Add New';

    protected string $valueField = Text::class;

    public function setKeyLabel(string $keyLabel): self
    {
        $this->keyLabel = $keyLabel;

        return $this;
    }

    public function setValueLabel(string $valueLabel): self
    {
        $this->valueLabel = $valueLabel;

        return $this;
    }

    public function setAddLabel(string $addLabel): self
    {
        $this->addLabel = $addLabel;

        return $this;
    }

    public function setValueField(string $valueField): self
    {
        if (!in_array($valueField, [
            Text::class,
            Email::class,
            Number::class,
            Password::class
        ])) {
            throw new \InvalidArgumentException('Field type is not acceptable for a key value field.');
        }
        $this->valueField = $valueField;

        return $this;
    }

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['required'] = in_array('required', $this->getRules()) || call_user_func($this->requiredCallback, $request);
        $data['keyLabel'] = trans($this->keyLabel);
        $data['valueLabel'] = trans($this->valueLabel);
        $data['addLabel'] = trans($this->addLabel);
        $data['valueComponent'] = 'fk-admin-field-text';

        $data['keyField'] = (new Text('key', $this->keyLabel))->toArray($request);

        $fieldClass = $this->valueField;
        $data['valueField'] = (new $fieldClass('value', $this->valueLabel))->toArray($request);

        return $data;
    }

    public function addValidationLabels(Validator $validator, Request $request, ScreenInterface $screen): Validator
    {
        $validator->addCustomAttributes([
            $this->getId().'.*' => $this->getLabel()
        ]);

        return $validator;
    }

    public function addValidationRules(Validator $validator, Request $request, ScreenInterface $screen): Validator
    {
        $validator->addRules([
            $this->getId().'.*' => $this->replaceValidationPatterns($request, $this->getRules())
        ]);

        return $validator;
    }
}
