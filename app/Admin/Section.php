<?php

declare(strict_types=1);

namespace FluentKit\Admin;

class Section implements SectionInterface
{
    public const SECTION_ID = 'section';

    protected int $priority = 10;

    protected string $icon = 'fa-home';

    protected string $label = '';

    protected array $screens = [];

    public function getId(): string
    {
        return static::SECTION_ID;
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

    public function registerScreen(ScreenInterface $screen): SectionInterface
    {
        $this->screens[$screen->getId()] = $screen;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'screens' => collect($this->screens)
                ->map(fn (ScreenInterface $screen) => $screen->toArray())
                ->sortBy('priority')
                ->toArray()
        ];
    }
}
