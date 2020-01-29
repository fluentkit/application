<?php

declare(strict_types=1);

namespace FluentKit\Admin\Dashboard\Screens;

use FluentKit\Admin\Screen;
use Illuminate\Http\Request;

final class MainDashboard extends Screen
{
    public const SCREEN_ID = 'main';

    protected int $priority = 10;

    protected string $label = 'Dashboard';

    protected bool $hideSectionTitle = true;

    public function getHtml(Request $request): array
    {
        return [
            'data' => [
                'template' => '
                    <div>
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
                        <div>
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
