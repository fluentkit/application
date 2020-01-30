<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasFields;
use FluentKit\Admin\UI\Traits\HasIcon;
use FluentKit\Admin\UI\Traits\HasId;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasPriority;
use Illuminate\Http\Request;

class Screen implements ScreenInterface
{
    use HasId, HasIcon, HasLabel, HasPriority, HasFields;

    protected bool $hideSectionTitle = false;

    protected string $type = 'html';

    protected array $actions = [];

    public function getHideSectionTitle(): bool
    {
        return $this->hideSectionTitle;
    }

    public function getType(): string
    {
        return $this->type;
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
            'component' => $this->getComponent(),
        ];
    }

    public function getAttributes(Request $request): array
    {
        return [
            'attributes' => []
        ];
    }

    public function getActions(Request $request): array
    {
        return [
            'actions' => collect($this->actions)
                            ->sortBy('priority')
                            ->values()
                            ->toArray()
        ];
    }

    public function getTemplate(Request $request): array
    {
        return [
            'template' => ''
        ];
    }
}
