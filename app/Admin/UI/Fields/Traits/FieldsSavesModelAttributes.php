<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait FieldsSavesModelAttributes
{
    public function saveAttributes(Model $model, Request $request): Model
    {
        foreach ($this->fields as $field) {
            $model = $field->saveAttributes($model, $request);
        }

        return $model;
    }
}
