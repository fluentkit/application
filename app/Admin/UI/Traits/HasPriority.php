<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

trait HasPriority
{
    protected int $priority = 10;

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }
}
