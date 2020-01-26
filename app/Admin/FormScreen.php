<?php

declare(strict_types=1);

namespace FluentKit\Admin;

use Illuminate\Http\Request;

abstract class FormScreen extends Screen implements ScreenInterface
{
    protected string $type = 'form';

    abstract public function getAttributes(Request $request): array;

    abstract public function saveAttributes(Request $request);
}
