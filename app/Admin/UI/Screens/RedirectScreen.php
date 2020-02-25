<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;

class RedirectScreen extends Screen implements ScreenInterface
{
    protected string $type = 'redirect';

    protected string $route = '';

    public function __construct(string $id, string $label, string $route)
    {
        $this->setId($id);
        $this->setLabel($label);
        $this->route = $route;
    }

    public function toArray(Request $request): array
    {
        $screen = parent::toArray($request);
        $screen['route'] = $this->route;

        return $screen;
    }
}
