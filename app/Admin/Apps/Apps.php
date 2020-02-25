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
use FluentKit\Admin\UI\Screens\RedirectScreen;
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
                (new Route('route', 'Name'))
                    ->route('apps.edit')
                    ->routeIdFrom('id')
                    ->routeLabelFrom('name'),
                (new Checkbox('master', 'Master'))->align('center'),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->createFields([
                new Panel('details', 'App Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string', 'unique:apps,name']),
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
                    ->createFields([
                        (new Text('domain', 'Domain'))->rules(['required', 'string', 'unique:app_domains,domain']),
                    ])
                    ->editFields([
                        (new Text('domain', 'Domain'))->rules(['required', 'string', 'unique:app_domains,domain,{$id}']),
                    ])
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
                    ->createFields([
                        (new Text('domain', 'Domain'))->rules(['required', 'string', 'unique:app_domains,domain']),
                    ])
                    ->editFields([
                        (new Text('domain', 'Domain'))->rules(['required', 'string', 'unique:app_domains,domain,{$id}']),
                    ])
            ]);

        $this->getScreen('index')->searchable(['id', 'name']);
        $this->registerScreen(new RedirectScreen('app_domains', 'Domains', 'app_domains'));
    }
}
