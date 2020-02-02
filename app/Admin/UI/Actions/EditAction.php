<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;

final class EditAction extends Action implements ActionInterface
{
    private $route;

    public function route(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function handle(Request $request, ScreenInterface $screen): array
    {
        return Redirect::route($this->route, ['id' => $request->get('id')])->toArray();
    }
}
