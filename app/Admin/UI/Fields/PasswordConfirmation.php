<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

final class PasswordConfirmation extends Password
{
    public function toArray(Request $request): array
    {
        $field = parent::toArray($request);
        $field['type'] = 'password';

        return $field;
    }

    public function saveAttributes(Model $model, Request $request): Model
    {
        // We dont want to add the confirmed field to the model attributes
        return $model;
    }
}
