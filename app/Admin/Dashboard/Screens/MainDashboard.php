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

    public function __construct()
    {
        $this->actions = [
            'save' => [
                'id' => 'save',
                'label' => 'Save Changes',
                'buttonType' => 'default',
                'priority' => 10,
                'disabled' => false,
                'action' => 'getAttributes'
            ],
            'draft' => [
                'id' => 'draft',
                'label' => 'Save Draft',
                'buttonType' => 'info',
                'icon' => 'fa-cog',
                'priority' => 5,
                'disabled' => false,
                'action' => 'draft'
            ],
            'discard' => [
                'id' => 'discard',
                'label' => 'Discard Changes',
                'buttonType' => 'danger',
                'icon' => 'fa-cog',
                'priority' => 10,
                'disabled' => false,
                'action' => 'bazzer'
            ],
        ];
    }

    public function getAttributes(Request $request): array
    {
        return [
            'attributes' => [
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
        ];
    }

    public function getTemplate(Request $request): array
    {
        return [
            'template' => '
                    <div>
                        <fk-admin-title>Foo bar</fk-admin-title>
                        <fk-admin-panel>
                            im from {{ attributes.foo }}
                        </fk-admin-panel>
                        <fk-admin-title>Bazzer</fk-admin-title>
                        <fk-admin-panel>
                            <fk-admin-field-row :field="attributes.email" v-model="attributes.attributes.email"/>
                            <fk-admin-field-row :field="attributes.text" v-model="attributes.attributes.text"/>
                        </fk-admin-panel>
                        <fk-admin-field-row :field="attributes.email" v-model="attributes.attributes.email"/>
                        <fk-admin-title>User Details</fk-admin-title>
                        <fk-admin-panel>
                            '.get_called_class(). '
                        </fk-admin-panel>
                        <fk-admin-form-actions :actions="actions"/>
                    </div>
                '
        ];
    }
}
