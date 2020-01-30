<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Actions;

use FluentKit\Admin\UI\ActionInterface;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasId;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasPriority;
use Illuminate\Http\Request;

abstract class Action
{
    use HasId, HasLabel, HasPriority;

    protected array $meta = [
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

    public function setMeta(string $key, $value): ActionInterface
    {
        data_set($this->meta, $key, $value);

        return $this;
    }

    public function getMeta(string $key = null): array
    {
        if ($key) {
            return data_get($this->meta, $key);
        }

        return $this->meta;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'label' => $this->getLabel(),
            'disabled' => false,
            'meta' => $this->getMeta(),
        ];
    }

    abstract public function handle(Request $request, ScreenInterface $screen): array;
}
