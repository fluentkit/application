<?php

declare(strict_types=1);

namespace FluentKit\Admin\Http\Controllers\Screen;

use FluentKit\Admin\Area;
use FluentKit\Http\Controllers\Controller;
use Illuminate\Http\Request;

final class ScreenActionsController extends Controller
{
    private ?Area $admin = null;

    public function __construct(Area $admin)
    {
        $this->admin = $admin;
    }

    public function postAction($section, $screen, $action, Request $request)
    {
        $section = $this->admin->getSection($section);
        $screen = $section->getScreen($screen);
        $action = $screen->getAction($action);

        return response()->json($action->handle($request, $screen));
    }
}
