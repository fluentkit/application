<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

trait HasMeta
{
    public function setMeta(string $key, $value): self
    {
        data_set($this->meta, $key, $value);

        return $this;
    }

    public function getMeta(string $key = null): array
    {
        if ($key) {
            return data_get($this->meta, $key);
        }

        return $this->meta;
    }
}
