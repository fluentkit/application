<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

use Illuminate\Http\Request;

trait LoadsRelations
{
    protected $with = [];

    public function with($relations): self
    {
        $this->with = $relations;

        return $this;
    }

    public function getWith(Request $request): array
    {
        if (is_callable($this->with)) {
            return call_user_func($this->with, $request);
        }

        return (array) $this->with;
    }
}
