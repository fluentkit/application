<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\UI\Fields\Checkbox;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Select;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\Screens\SettingScreen;
use FluentKit\Role;

final class GeneralSettings extends SettingScreen
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('app');
        $this->setLabel('General Settings');

        $this->addField(
            (new Panel('general', 'Application Settings', ''))
                ->addField(
                    (new Text('name', 'Application Name', 'Choose a suitable name for the application.'))
                        ->rules(['required'])
                )
                ->addField(
                    (new Select('timezone', 'Timezone', 'Choose the timezone your application uses.'))
                        ->options(
                            collect(\DateTimeZone::listIdentifiers())
                                ->map(fn ($zone) => ['id' => $zone, 'label' => $zone])
                                ->toArray()
                        )
                        ->rules(['required'])
                )
                ->addField(
                    (new Select('locale', 'Locale', 'Choose the main language for the application. The fallback is <code>en</code>.'))
                        ->options(
                            collect(array_diff(scandir(resource_path('lang')), array('..', '.')))
                                ->map(fn ($locale) => ['id' => $locale, 'label' => $locale])
                                ->toArray()
                        )
                        ->rules(['required'])
                )
                ->addField(
                    (new Text('date_format', 'Date Format', 'Default: <code>Y-m-d</code>. Possible formats can be found here: <a href="https://www.php.net/manual/en/function.date.php" target="_blank">https://www.php.net/manual/en/function.date.php</a>.'))
                        ->rules(['required'])
                )
                ->addField(
                    (new Text('time_format', 'Time Format', 'Default: <code>H:i:s</code>'))
                        ->rules(['required'])
                )
        );

        $this->addField(
            (new Panel('user', 'User Settings', ''))
                ->addField(
                    (new Select('user.role', 'Default User Role', 'Choose the role new users are assigned to if not specified.'))
                        ->options(
                            Role::all()
                                ->map(fn (Role $role) => ['id' => $role->name, 'label' => $role->name])
                                ->toArray()
                        )
                        ->rules(['required'])
                )
                ->addField(
                    (new Checkbox('user.registration', 'User Registration'))
                        ->setMeta('checkbox.label', 'Allow anyone to register')
                )
        );

        $this->addField(
            (new Panel('debug_mode', 'Debug Mode', 'You can enable debug mode to produce extended error messages when required.'))
                ->addField((new Checkbox('debug', 'Debug Mode', 'Ensure this is disabled in production.'))->setMeta('checkbox.label', 'Enabled'))
        );
    }
}
