<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

use Illuminate\Http\Request;

trait CanBeHidden
{
    protected $hidden = false;

    public function hide($hidden = true): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function getHidden(Request $request): bool
    {
        if (is_callable($this->hidden)) {
            return call_user_func($this->hidden, $request);
        }

        return (bool) $this->hidden;
    }
}
