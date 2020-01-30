<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings;

use FluentKit\Admin\UI\Section;
use FluentKit\Admin\Settings\Screens\GeneralSettings;

final class Settings extends Section
{
    public function __construct()
    {
        $this->setId('settings');
        $this->setIcon('fa-cog');
        $this->setLabel('Settings');
        $this->setPriority(20);

        $this->registerScreen(new GeneralSettings());
    }
}
