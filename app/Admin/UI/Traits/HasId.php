<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

trait HasId
{
    protected string $id = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
