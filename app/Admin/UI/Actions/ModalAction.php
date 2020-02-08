<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;

final class ModalAction extends Action implements ActionInterface
{
    public function __construct(string $id, string $label)
    {
        parent::__construct($id, $label);
        $this->setMeta('modal', [
            'title' => '',
            'body' => '',
            'size' => 'md'
        ]);
    }

    public function handle(Request $request, ScreenInterface $screen): array
    {
        return [];
    }
}
