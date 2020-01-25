<?php

declare(strict_types=1);

namespace FluentKit\Admin\Http\Controllers\Actions;

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

    public function postAction($section, $screen, $action = null, Request $request)
    {
        $section = $this->admin->getSection($section);
        $screen = $section->getScreen($screen);

        sleep(2);
        return response()->json($screen->{$action}($request));
    }
}
