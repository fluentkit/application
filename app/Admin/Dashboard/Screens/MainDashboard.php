<?php

declare(strict_types=1);

namespace FluentKit\Admin\Dashboard\Screens;

use FluentKit\Admin\UI\Screens\Screen;
use Illuminate\Http\Request;

final class MainDashboard extends Screen
{
    protected bool $hideSectionTitle = true;

    public function __construct()
    {
        $this->setId('main');
        $this->setLabel('Dashboard');
    }

    public function getAttributes(Request $request): array
    {
        return [
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
            ],
        ];
    }

    public function getTemplate(Request $request): string
    {
        return '
                <div>
                    <fk-admin-title>Foo bar</fk-admin-title>
                    <fk-admin-panel>
                        im from {{ attributes.foo }}
                    </fk-admin-panel>
                    <fk-admin-title>Bazzer</fk-admin-title>
                    <fk-admin-panel>
                        <pre>{{ attributes }}</pre>
                    </fk-admin-panel>
                    <fk-admin-title>User Details</fk-admin-title>
                    <fk-admin-panel>
                        '.get_called_class(). '
                    </fk-admin-panel>
                </div>
            ';
    }
}
