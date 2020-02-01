<?php

declare(strict_types=1);

namespace FluentKit\Admin\Users\Screens;

use FluentKit\Admin\UI\Actions\SaveAction;
use FluentKit\Admin\UI\Fields\Email;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\Screens\ModelScreen;
use FluentKit\User;

final class Edit extends ModelScreen
{
    protected string $id = 'edit';

    protected string $label = 'Edit User';

    protected $hidden = true;

    protected string $model = User::class;

    public function __construct()
    {
        $this->addField(
            (new Panel('details', 'User Details', ''))
                ->addField(
                    (new Email('email', 'Email Address', ''))
                        ->rules(['required', 'string', 'unique:users,email,{$id}'])
                )
                ->addField(
                    (new Text('first_name', 'First Name', ''))
                        ->rules(['required', 'string'])
                )
                ->addField(
                    (new Text('last_name', 'Last Name', ''))
                        ->rules(['required', 'string'])
                )
                ->addField(
                    (new Text('email_verified_at', 'Email Verified On', ''))
                        ->readOnly()
                )
                ->addField(
                    (new Text('created_at', 'Created At', ''))
                        ->readOnly()
                )
                ->addField(
                    (new Text('updated_at', 'Updated At', ''))
                        ->readOnly()
                )
        );

        $this->addAction(
            (new SaveAction('update', 'Update User'))
                ->saveCallback([$this, 'updateModel'])
        );
    }
}
