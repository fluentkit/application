<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Traits\CanBeDisabled;

final class Condition implements FieldConditionInterface
{
    use CanBeDisabled;

    private string $attribute = '';

    private string $operator = '=';

    private $comparisonValue = null;

    private bool $disableField = false;

    private bool $hideField = false;

    private bool $setFieldValue = false;

    private $fieldValue = null;

    public function when(string $attribute): FieldConditionInterface
    {
        $this->attribute = $attribute;

        return $this;
    }

    public function equals($value): FieldConditionInterface
    {
        $this->operator = '=';
        $this->comparisonValue = $value;

        return $this;
    }

    public function notEquals($value): FieldConditionInterface
    {
        $this->operator = '!=';
        $this->comparisonValue = $value;

        return $this;
    }

    public function contains($value): FieldConditionInterface
    {
        $this->operator = 'contains';
        $this->comparisonValue = $value;

        return $this;
    }

    public function includes($value): FieldConditionInterface
    {
        $this->operator = 'includes';
        $this->comparisonValue = $value;

        return $this;
    }

    public function between($start, $end): FieldConditionInterface
    {
        $this->operator = 'between';
        $this->comparisonValue = [$start, $end];

        return $this;
    }

    public function moreThan($value): FieldConditionInterface
    {
        $this->operator = '>';
        $this->comparisonValue = $value;

        return $this;
    }

    public function lessThan($value): FieldConditionInterface
    {
        $this->operator = '<';
        $this->comparisonValue = $value;

        return $this;
    }

    public function setDisabled($disabled = true): FieldConditionInterface
    {
        $this->disableField = $disabled;

        return $this;
    }

    public function setHidden($hidden = true): FieldConditionInterface
    {
        $this->hideField = $hidden;

        return $this;
    }

    public function setValue($value): FieldConditionInterface
    {
        $this->setFieldValue = true;
        $this->fieldValue = $value;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'attribute' => $this->attribute,
            'operator' => $this->operator,
            'comparisonValue' => $this->comparisonValue,
            'disableField' => $this->disableField,
            'hideField' => $this->hideField,
            'setFieldValue' => $this->setFieldValue,
            'fieldValue' => $this->fieldValue,
        ];
    }
}
