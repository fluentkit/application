<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

use Illuminate\Http\Request;

trait CanBeReadOnly
{
    protected $readOnly = false;

    public function readOnly($readOnly = true): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    public function getReadOnly(Request $request): bool
    {
        if (is_callable($this->readOnly)) {
            return call_user_func($this->readOnly, $request);
        }

        return (bool) $this->readOnly;
    }
}
