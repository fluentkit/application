<?php

declare(strict_types=1);

namespace FluentKit\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class FormScreen extends Screen implements ScreenInterface
{
    protected string $type = 'form';

    public function saveAttributes(Request $request): array
    {
        $fields = collect($this->fields)
            ->reduce(function (array $fields, FieldInterface $field) {
                return array_merge($fields, $field->getRules());
            }, []);

        Validator::make($request->get('attributes'), $fields)->validate();

        return $this->save($request);
    }

    abstract public function save(Request $request): array;
}
