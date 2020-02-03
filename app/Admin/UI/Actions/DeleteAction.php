<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;

final class DeleteAction extends CallbackAction implements ActionInterface
{
    public function __construct(string $id, string $label)
    {
        parent::__construct($id, $label);
        $this->setMeta('button.type', 'danger')
            ->setMeta('button.icon', 'fa-trash')
            ->setMeta('confirmable', true)
            ->setMeta('modal.title', 'Are you sure?')
            ->setMeta('modal.size', 'sm')
            ->setMeta('modal.confirm.type', 'danger')
            ->setMeta('modal.confirm.icon', 'fa-trash');
    }

    public function handle(Request $request, ScreenInterface $screen): array
    {
        $response = call_user_func($this->callback, $request, $screen);

        if (!$response || !$response instanceof ResponseInterface) {
            $response = Notification::success('Deleted!');
        }

        return $response->toArray();
    }
}
