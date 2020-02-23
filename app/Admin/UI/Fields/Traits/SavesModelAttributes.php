<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait SavesModelAttributes
{
    public function saveAttributes(Model $model, Request $request): Model
    {
        if ($request->has('attributes.'.$this->getId())) {
            $model->setAttribute($this->getId(), $request->input('attributes.'.$this->getId()));
        }

        return $model;
    }
}
