<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

use Illuminate\Http\Request;

trait CanBeDisabled
{
    protected $disabled = false;

    public function disable($disabled = true): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function getDisabled(Request $request): bool
    {
        if (is_callable($this->disabled)) {
            return call_user_func($this->disabled, $request);
        }

        if (is_string($this->disabled)) {
            return !$request->user()->can($this->disabled);
        }

        return (bool) $this->disabled;
    }
}
