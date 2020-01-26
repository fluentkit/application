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
                    <div class="flex flex-col flex-grow">
                        <fk-admin-title>Foo bar</fk-admin-title>
                        <fk-admin-panel>
                            im from {{ foo }}
                        </fk-admin-panel>
                        <fk-admin-title>Bazzer</fk-admin-title>
                        <fk-admin-panel>
                            <fk-admin-field-row :field="email" v-model="attributes.email"/>
                            <fk-admin-field-row :field="text" v-model="attributes.text"/>
                        </fk-admin-panel>
                        <fk-admin-field-row :field="email" v-model="attributes.email"/>
                        <fk-admin-title>User Details</fk-admin-title>
                        <fk-admin-panel>
                            '.get_called_class(). '
                        </fk-admin-panel>
                        <div class="flex flex-row">
                            <fk-admin-button @click="$toast(\'look at me!\')">Save Changes</fk-admin-button>
                            <fk-admin-button type="info" @click="$info(\'look at me!\')">Save Changes Much Longer Button</fk-admin-button>
                            <fk-admin-button type="success" @click="$success(\'look at me!\')">Save Changes</fk-admin-button>
                            <fk-admin-button type="danger" @click="$error(\'look at me!\')"><i class="fa fa-home"></i></fk-admin-button>
                        </div>
                    </div>
                ',
                'data' => [
                    'foo' => 'bar',
                    'email' => [
                        'id' => 'email',
                        'label' => 'Email Address',
                        'type' => 'text',
                        'required' => true,
                        'description' => 'foo bar bazzer!',
                    ],
                    'text' => [
                        'id' => 'text',
                        'label' => 'Text',
                        'type' => 'text',
                        'required' => false,
                        'description' => 'foo bar bazzer!',
                    ],
                    'attributes' => [
                        'email' => 'foo',
                        'text' => 'bar'
                    ]
                ]
            ],
        ];
    }
}
