<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;

final class SaveAction extends Action implements ActionInterface
{
    private $callback;

    public function saveCallback(callable $callback): self
    {
        $this->callback = $callback;

        return $this;
    }

    public function handle(Request $request, ScreenInterface $screen): array
    {
        $screen->validateAttributes($request);

        $response = call_user_func($this->callback, $request);

        if (!$response || !$response instanceof ResponseInterface) {
            $response = Notification::success('Settings Updated!');
        }

        $response = $response->toArray();
        $response['attributes'] = $screen->getAttributes($request);

        return $response;
    }
}
