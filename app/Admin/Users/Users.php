<?php

declare(strict_types=1);

namespace FluentKit\Admin\Users;

use FluentKit\Admin\UI\Fields\Email;
use FluentKit\Admin\UI\Fields\KeyValue;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Password;
use FluentKit\Admin\UI\Fields\PasswordConfirmation;
use FluentKit\Admin\UI\Fields\Relationships\BelongsToMany;
use FluentKit\Admin\UI\Fields\Route;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\Admin\UI\Screens\RedirectScreen;
use FluentKit\Permission;
use FluentKit\Role;
use FluentKit\User;

final class Users extends ModelSection
{
    public function __construct()
    {
        parent::__construct(User::class);

        $this->setIcon('fa-user');
        $this->with(['roles', 'permissions']);

        $this->indexFields([
                (new Number('id', 'ID')),
                (new Email('email', 'Email Address')),
                (new Text('name', 'Name')),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->createFields([
                new Panel('details', 'User Details', '', [
                    (new Email('email', 'Email Address'))->rules(['required', 'string', 'unique:users,email']),
                    (new Text('first_name', 'First Name'))->rules(['required', 'string']),
                    (new Text('last_name', 'Last Name'))->rules(['required', 'string']),
                    (new KeyValue('meta', 'Meta')),
                ]),
                (new BelongsToMany('roles', Role::class, 'User roles allow you to provide group style permissions for a user. A user can have one or many roles.'))
                    ->setLabel('Roles')
                    ->labelFrom('name')
                    ->indexFields([
                        (new Number('id', 'ID')),
                        (new Route('route', 'Role'))
                            ->route('roles.edit')
                            ->routeIdFrom('id')
                            ->routeLabelFrom('name'),
                        (new Text('created_at', 'Created At')),
                        (new Text('updated_at', 'Updated At'))
                    ]),
                (new BelongsToMany('permissions', Permission::class, 'You can optionally provide a user with specific permissions not found within their assigned roles.'))
                    ->setLabel('Permissions')
                    ->labelFrom('name')
                    ->indexFields([
                        (new Number('id', 'ID')),
                        (new Route('route', 'Permission'))
                            ->route('permissions.edit')
                            ->routeIdFrom('id')
                            ->routeLabelFrom('name'),
                        (new Text('created_at', 'Created At')),
                        (new Text('updated_at', 'Updated At'))
                    ]),
                new Panel('passwords', 'Password', '', [
                    (new Password('password', 'Password'))->rules(['required', 'string', 'min:10', 'confirmed']),
                    (new PasswordConfirmation('password_confirmation', 'Retype Password'))->rules(['required', 'string', 'min:10']),
                ])
            ])
            ->editFields([
                new Panel('details', 'User Details', '', [
                    (new Email('email', 'Email Address'))->rules(['required', 'string', 'unique:users,email,{$id}']),
                    (new Text('first_name', 'First Name'))->rules(['required', 'string']),
                    (new Text('last_name', 'Last Name'))->rules(['required', 'string']),
                    (new KeyValue('meta', 'Meta')),
                    (new Text('email_verified_at', 'Email Verified On'))->rules(['nullable'])->readOnly(),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ]),
                (new BelongsToMany('roles', Role::class, 'User roles allow you to provide group style permissions for a user. A user can have one or many roles.'))
                    ->setLabel('Roles')
                    ->labelFrom('name')
                    ->indexFields([
                        (new Number('id', 'ID')),
                        (new Route('route', 'Role'))
                            ->route('roles.edit')
                            ->routeIdFrom('id')
                            ->routeLabelFrom('name'),
                        (new Text('created_at', 'Created At')),
                        (new Text('updated_at', 'Updated At'))
                    ]),
                (new BelongsToMany('permissions', Permission::class, 'You can optionally provide a user with specific permissions not found within their assigned roles.'))
                    ->setLabel('Permissions')
                    ->labelFrom('name')
                    ->indexFields([
                        (new Number('id', 'ID')),
                        (new Route('route', 'Permission'))
                            ->route('permissions.edit')
                            ->routeIdFrom('id')
                            ->routeLabelFrom('name'),
                        (new Text('created_at', 'Created At')),
                        (new Text('updated_at', 'Updated At'))
                    ]),
                new Panel('passwords', 'Password', 'Enter a new password to change the users password.', [
                    (new Password('password', 'Password'))->rules(['sometimes', 'string', 'min:10', 'confirmed']),
                    (new PasswordConfirmation('password_confirmation', 'Retype Password'))->rules(['sometimes', 'required_with:passwords', 'string', 'min:10']),
                ])
            ]);

        $this->getScreen('index')->searchable(['id', 'email', 'first_name', 'last_name']);

        $this->registerScreen((new RedirectScreen('roles', 'Roles', 'roles')));
        $this->registerScreen((new RedirectScreen('permissions', 'Permissions', 'permissions')));
    }
}
