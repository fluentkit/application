<?php

declare(strict_types=1);

namespace FluentKit\Admin\Http\Controllers\Screen;

use FluentKit\Admin\Area;
use FluentKit\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
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
        $actionIds = explode('.', $action);
        $action = $screen;

        foreach ($actionIds as $id) {
            $action = $action->getAction($id);

            if (!$action) {
                throw new \InvalidArgumentException('Missing action!');
            }
        }

        if ($action->getDisabled($request) === true) {
            throw new AuthorizationException('You cannot perform this action!');
        }

        return response()->json($action->handle($request, $screen));
    }
}
