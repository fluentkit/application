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

    protected string $type = 'html';

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
            'type' => $this->getType(),
            'component' => $this->getComponent(),
        ];
    }

    public function getHtml(Request $request): array
    {
        return [
            'data' => [
                'template' => '
                    <div class="flex-1 bg-white shadow-md rounded p-10 mb-10">
                        im from {{ foo }}
                    </div>
                    <div class="flex-1 bg-white shadow-md rounded p-10 mb-10" @click="$success(\'look at me!\')">
                        <pre>{{ $data }}{{ $section }}{{ $screen }}{{ $data }}{{ $section }}{{ $screen }}</pre>
                    </div>
                    <div class="flex-1 bg-white shadow-md rounded p-10">
                        '.get_called_class().'
                    </div>
                ',
                'data' => [
                    'foo' => 'bar'
                ]
            ],
        ];
    }
}
