<?php

declare(strict_types=1);

namespace FluentKit\Admin\Apps;

use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\App;

final class Apps extends ModelSection
{
    public function __construct()
    {
        parent::__construct(App::class);

        $this->setIcon('fa-globe');

        $this->indexFields([
                (new Number('id', 'ID')),
                (new Text('name', 'Name')),
                (new Number('master', 'Master')),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->createFields([
                new Panel('details', 'App Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string', 'unique:apps,name']),
                ]),
            ])
            ->editFields([
                new Panel('details', 'App Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string', 'unique:apps,name,{$id}']),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ]),
            ]);

        $this->getScreen('index')->searchable(['id', 'name']);
    }
}
