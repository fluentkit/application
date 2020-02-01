<?php

declare(strict_types=1);

namespace FluentKit\Admin\Dashboard\Screens;

use FluentKit\Admin\UI\Screens\Screen;
use Illuminate\Http\Request;

final class MainDashboard extends Screen
{
    protected string $id = 'main';

    protected string $label = 'Dashboard';

    protected bool $hideSectionTitle = true;

    public function getTemplate(Request $request): string
    {
        return '
                <div>
                    <fk-admin-title>Foo bar</fk-admin-title>
                    <fk-admin-panel>
                        im from {{ $props }}
                    </fk-admin-panel>
                    <fk-admin-title>Bazzer</fk-admin-title>
                    <fk-admin-panel>
                        <pre>{{ $data }}</pre>
                    </fk-admin-panel>
                    <fk-admin-title>User Details</fk-admin-title>
                    <fk-admin-panel>
                        '.get_called_class(). '
                    </fk-admin-panel>
                </div>
            ';
    }
}
