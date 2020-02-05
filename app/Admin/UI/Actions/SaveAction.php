<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;

final class SaveAction extends CallbackAction implements ActionInterface
{
    public function handle(Request $request, ScreenInterface $screen): array
    {
        $screen->validateAttributes($request);

        $response = call_user_func($this->callback, $request, $screen);

        if (!$response || !$response instanceof ResponseInterface) {
            $response = Notification::success('Saved!');
        }

        return  $response->toArray();
    }
}
