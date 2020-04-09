<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\UI\Fields\Condition;
use FluentKit\Admin\UI\Fields\Email;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Password;
use FluentKit\Admin\UI\Fields\Select;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\Screens\SettingScreen;

final class MailSettings extends SettingScreen
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('mail');
        $this->setLabel('Mail Settings');
        $this->disable('setting.mail.viewAny');

        $this->addField(
            (new Panel('main', 'Mail Configuration', 'Details entered here are used for all default mail sending.'))
                ->addField(
                    (new Email('from.address', 'From Address', 'Please enter an email address you would like emails to be delivered from.'))
                        ->rules(['required'])
                )
                ->addField(
                    (new Text('from.name', 'From Name', 'Enter the name you would like this email to be delivered as.'))
                        ->rules(['required'])
                )
                ->addField(
                    (new Select('default', 'Mail Driver', 'Choose the mail driver to deliver emails. The <code>log</code> and <code>array</code> are for debugging or suppressing mail only.'))
                        ->options([
                            [ 'id' => 'mail', 'label' => trans('PHP Mail') ],
                            [ 'id' => 'smtp', 'label' => trans('SMTP') ],
                            [ 'id' => 'ses', 'label' => trans('Amazon SES') ],
                            [ 'id' => 'mailgun', 'label' => trans('Mailgun') ],
                            [ 'id' => 'postmark', 'label' => trans('Postmark') ],
                            [ 'id' => 'sendmail', 'label' => trans('Sendmail') ],
                            [ 'id' => 'log', 'label' => trans('Log') ],
                            [ 'id' => 'array', 'label' => trans('Array') ],
                        ])
                        ->rules(['required'])
                )
        );

        $this->addField(
            (new Panel('smtp', 'SMTP Connection Settings'))
                ->addCondition(
                    (new Condition())
                        ->when('default')
                        ->notEquals('smtp')
                        ->setHidden()
                )
                ->addField(new Text('mailers.smtp.host', 'Host'))
                ->addField(new Number('mailers.smtp.port', 'Port'))
                ->addField(
                    (new Select('mailers.smtp.encryption', 'Encryption'))
                        ->options([
                            [ 'id' => 'tls', 'label' => trans('TLS') ],
                            [ 'id' => 'ssl', 'label' => trans('SSL') ],
                        ])
                )
                ->addField(new Text('mailers.smtp.username', 'Username'))
                ->addField(new Password('mailers.smtp.password', 'Password'))
        );

        $this->addField(
            (new Panel('sendmail', 'Sendmail Settings'))
                ->addCondition(
                    (new Condition())
                        ->when('default')
                        ->notEquals('sendmail')
                        ->setHidden()
                )
                ->addField(new Text('mailers.sendmail.path', 'Binary Path', 'Default: <code>/usr/sbin/sendmail -bs</code>'))
        );
    }
}
