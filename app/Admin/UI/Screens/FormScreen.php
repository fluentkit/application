<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class FormScreen extends Screen implements ScreenInterface
{
    protected string $type = 'form';

    public function validateAttributes(Request $request): void
    {
        $validator = Validator::make($request->get('attributes'), [], []);

        foreach ($this->fields as $field) {
            $validator = $field->addValidationLabels($validator, $request, $this);
            $validator = $field->addValidationRules($validator, $request, $this);
        }

        $validator->validate();
    }
}
