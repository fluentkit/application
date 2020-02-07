<?php

declare(strict_types=1);

namespace FluentKit\Admin\Apps;

use FluentKit\Admin\UI\Fields\Checkbox;
use FluentKit\Admin\UI\Fields\Relationships\HasMany;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Route;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\App;
use FluentKit\AppDomain;

final class Apps extends ModelSection
{
    public function __construct()
    {
        parent::__construct(App::class);

        $this->setIcon('fa-globe');

        $this->with(['domains']);

        $this->indexFields([
                (new Number('id', 'ID')),
                (new Text('name', 'Name')),
                (new Checkbox('master', 'Master'))->align('center'),
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
                    (new Checkbox('master', 'Master'))->readOnly(),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ]),
                (new HasMany('domains', AppDomain::class, 'Each application can have many associated domains, but must have at least one.'))
                    ->setLabel('Domains')
                    ->indexFields([
                        (new Number('id', 'ID')),
                        (new Route('route', 'Domain'))
                            ->route('app_domains.edit')
                            ->routeIdFrom('id')
                            ->routeLabelFrom('domain'),
                        (new Text('created_at', 'Created At')),
                        (new Text('updated_at', 'Updated At'))
                    ])
                    ->editFields([
                        (new Number('id', 'ID')),
                        new Text('domain', 'Domain'),
                        (new Text('created_at', 'Created At'))->readOnly(),
                        (new Text('updated_at', 'Updated At'))->readOnly()
                    ])
            ]);

        $this->getScreen('index')->searchable(['id', 'name']);
    }
}
