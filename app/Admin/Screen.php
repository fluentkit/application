<?php

declare(strict_types=1);

namespace FluentKit\Admin;

use Illuminate\Http\Request;

class Screen implements ScreenInterface
{
    public const SCREEN_ID = 'screen';

    protected int $priority = 10;

    protected string $icon = 'fa-home';

    protected string $label = '';

    protected bool $hideSectionTitle = false;

    protected string $type = 'html';

    protected array $fields = [];

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

    public function getHideSectionTitle(): bool
    {
        return $this->hideSectionTitle;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getComponent(): string
    {
        return 'fk-admin-screen-' . $this->getType();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'hideSectionTitle' => $this->getHideSectionTitle(),
            'type' => $this->getType(),
            'fields' => $this->getFields(),
            'component' => $this->getComponent(),
        ];
    }

    public function getHtml(Request $request): array
    {
        return [
            'data' => [
                'template' => '',
                'data' => []
            ]
        ];
    }
}
