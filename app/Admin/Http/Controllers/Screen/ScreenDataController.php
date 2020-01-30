<?php

declare(strict_types=1);

namespace FluentKit\Admin\Http\Controllers\Screen;

use FluentKit\Admin\Area;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class ScreenDataController extends Controller
{
    private ?Area $admin = null;

    public function __construct(Area $admin)
    {
        $this->admin = $admin;
    }

    private function getScreen($section, $screen): ?ScreenInterface
    {
        $section = $this->admin->getSection($section);
        return $section->getScreen($screen);
    }

    public function getFields($section, $screen, Request $request)
    {
        $screen = $this->getScreen($section, $screen);

        return response()->json(['fields' => $screen->getFields($request)]);
    }

    public function getAttributes($section, $screen, Request $request)
    {
        $screen = $this->getScreen($section, $screen);

        return response()->json(['attributes' => $screen->getAttributes($request)]);
    }

    public function getActions($section, $screen, Request $request)
    {
        $screen = $this->getScreen($section, $screen);

        return response()->json(['actions' => $screen->getActions($request)]);
    }

    public function getTemplate($section, $screen, Request $request)
    {
        $screen = $this->getScreen($section, $screen);

        return response()->json(['template' => $screen->getTemplate($request)]);
    }
}
