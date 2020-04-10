<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\UI\Fields\Checkbox;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Select;
use FluentKit\Admin\UI\Screens\SettingScreen;

final class SessionSettings extends SettingScreen
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('session');
        $this->setLabel('Session Settings');

        $this->addField(
            (new Panel('cache', 'Session Settings', ''))
                ->addField(
                    (new Select('driver', 'Session Driver', 'Choose one of the available session drivers. The <code>array</code> is for debugging purposes only and will not maintain a session. <strong>IMPORTANT!</strong> When changed you wil be required to login again.'))
                        ->options([
                            ['id' => 'database', 'label' => trans('Database')],
                            ['id' => 'file', 'label' => trans('File')],
                            ['id' => 'apc', 'label' => trans('APC')],
                            ['id' => 'cookie', 'label' => trans('Cookie')],
                            ['id' => 'array', 'label' => trans('Array')]
                        ])
                        ->rules(['required'])
                )
                ->addField(
                    (new Number('lifetime', 'Session Lifetime', 'Here you may specify the number of minutes that you wish the session to be allowed to remain idle before it expires.'))
                        ->rules(['required', 'numeric'])
                )
                ->addField(
                    (new Checkbox('expire_on_close', 'Expire On Close', 'When enabled sessions are terminated when the user closes the browser window.'))
                        ->setMeta('checkbox.label', 'Enable')
                )
                ->addField(
                    (new Checkbox('encrypt', 'Encrypt Session', 'This option allows you to easily specify that all of your session data should be encrypted before it is stored.'))
                        ->setMeta('checkbox.label', 'Enable')
                )
                ->addField(
                    (new Select('same_site', 'Same Site', 'This option determines how your cookies behave when cross-site requests take place, and can be used to mitigate CSRF attacks.'))
                        ->options([
                            ['id' => 'lax', 'label' => trans('Lax')],
                            ['id' => 'strict', 'label' => trans('Strict')],
                            ['id' => 'none', 'label' => trans('None')]
                        ])
                        ->rules(['required'])
                )
        );
    }
}
