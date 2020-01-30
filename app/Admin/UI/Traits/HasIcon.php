<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

trait HasIcon
{
    protected string $icon = '';

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }
}
