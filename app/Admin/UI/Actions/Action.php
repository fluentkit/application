<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\CanBeDisabled;
use FluentKit\Admin\UI\Traits\HasActions;
use FluentKit\Admin\UI\Traits\HasId;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasMeta;
use FluentKit\Admin\UI\Traits\HasPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Action
{
    use HasId, HasLabel, HasPriority, HasMeta, CanBeDisabled, HasActions;

    protected array $meta = [
        'location' => 'primary',
        'button' => [
            'type' => 'info',
            'icon' => null,
        ],
    ];

    public function __construct(string $id, string $label)
    {
        $this->setId($id);
        $this->setLabel($label);
    }

    public function location(string $location): ActionInterface
    {
        return $this->setMeta('location', $location);
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'type' => Str::snake(class_basename(get_called_class())),
            'label' => $this->getLabel(),
            'disabled' => $this->getDisabled($request),
            'meta' => $this->getMeta(),
            'actions' => $this->getActions($request),
        ];
    }

    abstract public function handle(Request $request, ScreenInterface $screen): array;
}
