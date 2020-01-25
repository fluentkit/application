<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings;

use FluentKit\Admin\Section;
use FluentKit\Admin\Settings\Screens\GeneralSettings;

final class Settings extends Section
{
    public const SECTION_ID = 'settings';

    protected int $priority = 20;

    protected string $icon = 'fa-cog';

    protected string $label = 'Settings';

    public function __construct()
    {
        $this->registerScreen(new GeneralSettings());
    }
}
