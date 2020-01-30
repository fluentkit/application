<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

trait HasLabel
{
    protected string $label = '';

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return trans($this->label);
    }
}
