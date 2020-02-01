<?php

declare(strict_types=1);

namespace FluentKit\Admin\Users;

use FluentKit\Admin\UI\Fields\Email;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Password;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\User;

final class Users extends ModelSection
{
    public function __construct()
    {
        parent::__construct(User::class, [
            'create' => [
                new Panel('details', 'User Details', '', [
                    (new Email('email', 'Email Address'))->rules(['required', 'string', 'unique:users,email']),
                    (new Text('first_name', 'First Name'))->rules(['required', 'string']),
                    (new Text('last_name', 'Last Name'))->rules(['required', 'string']),
                ]),
                new Panel('passwords', 'Password', '', [
                    (new Password('password', 'Password'))->rules(['required', 'string', 'min:10', 'confirmed']),
                    (new Password('password_confirmation', 'Retype Password'))->rules(['required', 'string', 'min:10']),
                ])
            ],
            'edit' => [
                new Panel('details', 'User Details', '', [
                    (new Email('email', 'Email Address'))->rules(['required', 'string', 'unique:users,email,{$id}']),
                    (new Text('first_name', 'First Name'))->rules(['required', 'string']),
                    (new Text('last_name', 'Last Name'))->rules(['required', 'string']),
                    (new Text('email_verified_at', 'Email Verified On'))->readOnly(),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ])
            ]
        ]);

        $this->setIcon('fa-user');
    }
}
