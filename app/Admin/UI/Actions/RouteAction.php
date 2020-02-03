<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;

final class RouteAction extends Action implements ActionInterface
{
    public function route(string $route, array $params = []): ActionInterface
    {
        $this->setMeta('route.id', $route)
            ->setMeta('route.params', $params);

        return $this;
    }

    public function handle(Request $request, ScreenInterface $screen): array
    {
        return [];
    }
}
