<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
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

        call_user_func($this->callback, $request);

        return [
            'message' => 'Settings Updated!',
            'type' => 'success',
            'attributes' => $screen->getAttributes($request)
        ];
    }
}
