<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

interface FieldConditionInterface
{
    public function when(string $attribute): self;

    public function equals($value): self;

    public function notEquals($value): self;

    public function contains($value): self;

    public function includes($value): self;

    public function between($start, $end): self;

    public function moreThan($value): self;

    public function lessThan($value): self;

    public function setDisabled($disable = true): self;

    public function setHidden($hidden = true): self;

    public function setValue($value): self;

    public function toArray(): array;
}
