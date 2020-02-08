<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;

class CallbackAction extends Action implements ActionInterface
{
    protected $callback;

    public function callback(callable $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function handle(Request $request, ScreenInterface $screen): array
    {
        $response = call_user_func($this->callback, $request, $screen);

        if (!$response || !$response instanceof ResponseInterface) {
            $response = Notification::success('Success!');
        }

        return $response->toArray();
    }
}
