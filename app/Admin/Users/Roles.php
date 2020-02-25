<?php

declare(strict_types=1);

namespace FluentKit\Admin\Users;

use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Relationships\BelongsToMany;
use FluentKit\Admin\UI\Fields\Route;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\Permission;
use FluentKit\Role;
use FluentKit\User;

final class Roles extends ModelSection
{
    public function __construct()
    {
        parent::__construct(Role::class);

        $this->setIcon('fa-user-lock');
        $this->with(['permissions', 'users']);
        $this->hide();

        $this->indexFields([
                (new Number('id', 'ID')),
                (new Route('route', 'Name'))
                    ->route('roles.edit')
                    ->routeIdFrom('id')
                    ->routeLabelFrom('name'),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->createFields([
                new Panel('details', 'Role Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string', 'unique:roles,name']),
                ]),
                (new BelongsToMany('permissions', Permission::class, ''))
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
                (new BelongsToMany('users', User::class, ''))
                    ->setLabel('Users')
                    ->labelFrom('email')
                    ->indexFields([
                        (new Number('id', 'ID')),
                        (new Route('route', 'Email Address'))
                            ->route('users.edit')
                            ->routeIdFrom('id')
                            ->routeLabelFrom('email'),
                        (new Text('created_at', 'Created At')),
                        (new Text('updated_at', 'Updated At'))
                    ]),
            ])
            ->editFields([
                new Panel('details', 'Role Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string', 'unique:roles,name,{$id}']),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ]),
                (new BelongsToMany('permissions', Permission::class, ''))
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
                (new BelongsToMany('users', User::class, ''))
                    ->setLabel('Users')
                    ->labelFrom('email')
                    ->indexFields([
                        (new Number('id', 'ID')),
                        (new Route('route', 'Email Address'))
                            ->route('users.edit')
                            ->routeIdFrom('id')
                            ->routeLabelFrom('email'),
                        (new Text('created_at', 'Created At')),
                        (new Text('updated_at', 'Updated At'))
                    ]),
            ]);

        $this->getScreen('index')->searchable(['id', 'name']);
    }
}
