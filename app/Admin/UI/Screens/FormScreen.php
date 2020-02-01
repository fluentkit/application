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
        $fields = $this->getFieldRules();
        $fieldNames = $this->getFieldLabels();

        $rules = collect($fields)->map(function (array $rules) use ($request) {
            return collect($rules)->map(function ($rule) use ($request) {
                return str_replace('{$id}', $request->get('id'), (string) $rule);
            })->toArray();
        })->toArray();

        Validator::make($request->get('attributes'), $rules, [], $fieldNames)->validate();
    }
}
