<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings;

use FluentKit\Admin\Settings\Screens\CacheSettings;
use FluentKit\Admin\Settings\Screens\DiskSettings;
use FluentKit\Admin\Settings\Screens\MailSettings;
use FluentKit\Admin\UI\Screens\RedirectScreen;
use FluentKit\Admin\UI\Section;
use FluentKit\Admin\Settings\Screens\GeneralSettings;

final class Settings extends Section
{
    public function __construct()
    {
        $this->setId('settings');
        $this->setIcon('fa-cog');
        $this->setLabel('Settings');
        $this->setPriority(100);
        $this->disable('setting.viewAny');

        $this->registerScreen(new GeneralSettings());
        $this->registerScreen(new MailSettings());
        $this->registerScreen(new CacheSettings());
        $this->registerScreen(new DiskSettings());
        $this->registerScreen(new RedirectScreen('services', 'Services', 'services'));
    }
}
