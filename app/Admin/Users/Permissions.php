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

final class Permissions extends ModelSection
{
    public function __construct()
    {
        parent::__construct(Permission::class);

        $this->setIcon('fa-lock');
        $this->with(['roles', 'users']);
        $this->hide();

        $this->indexFields([
                (new Number('id', 'ID')),
                (new Text('name', 'Name')),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->editFields([
                new Panel('details', 'Permission Details', 'You cannot update a permission directly, however you can attach the permission to various roles.', [
                    (new Text('name', 'Name'))->rules(['required', 'string', 'unique:permissions,name,{$id}'])->readOnly(),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ]),
                (new BelongsToMany('roles', Role::class, ''))
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
        $this->getScreen('index')->getAction('create')->disable();
        $this->getScreen('index')->getAction('delete')->disable();
        $this->getScreen('edit')->getAction('delete')->disable();
    }
}
