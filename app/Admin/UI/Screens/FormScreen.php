<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class FormScreen extends Screen implements ScreenInterface
{
    protected string $type = 'form';

    public function validateAttributes(Request $request): void
    {
        $fields = $this->getFieldRules();

        Validator::make($request->get('attributes'), $fields)->validate();
    }
}
