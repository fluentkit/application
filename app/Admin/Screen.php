<?php

declare(strict_types=1);

namespace FluentKit\Admin;

class Screen implements ScreenInterface
{
    public const SCREEN_ID = 'screen';

    protected int $priority = 10;

    protected string $icon = 'fa-home';

    protected string $label = '';

    public function getId(): string
    {
        return static::SCREEN_ID;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getLabel(): string
    {
        return trans($this->label);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
        ];
    }
}
