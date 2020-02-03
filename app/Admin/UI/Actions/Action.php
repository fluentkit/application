<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\CanBeDisabled;
use FluentKit\Admin\UI\Traits\HasId;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasMeta;
use FluentKit\Admin\UI\Traits\HasPriority;
use Illuminate\Http\Request;

abstract class Action
{
    use HasId, HasLabel, HasPriority, HasMeta, CanBeDisabled;

    protected array $meta = [
        'button' => [
            'type' => 'info',
            'icon' => null,
        ],
        'confirmable' => false,
        'modal' => [
            'title' => 'Confirm',
            'body' => 'Please confirm to continue.',
            'cancel' => [
                'id' => 'cancel',
                'type' => 'default',
                'label' => 'Cancel',
                'icon' => ''
            ],
            'confirm' => [
                'id' => 'confirm',
                'type' => 'info',
                'label' => 'Confirm',
                'icon' => ''
            ]
        ]
    ];

    public function __construct(string $id, string $label)
    {
        $this->setId($id);
        $this->setLabel($label);
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'label' => $this->getLabel(),
            'disabled' => $this->getDisabled($request),
            'meta' => $this->getMeta(),
        ];
    }

    abstract public function handle(Request $request, ScreenInterface $screen): array;
}
