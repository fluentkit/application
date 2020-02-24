<?php

declare(strict_types=1);

namespace FluentKit\Admin\Roles;

use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\Role;

final class Roles extends ModelSection
{
    public function __construct()
    {
        parent::__construct(Role::class);

        $this->setIcon('fa-user-lock');

        $this->indexFields([
                (new Number('id', 'ID')),
                (new Text('name', 'Name')),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->createFields([
                new Panel('details', 'Role Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string', 'unique:roles,name']),
                ]),
            ])
            ->editFields([
                new Panel('details', 'Role Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string', 'unique:roles,name,{$id}']),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ]),
            ]);

        $this->getScreen('index')->searchable(['id', 'name']);
        $this->getScreen('create')->hide(true);
    }
}
