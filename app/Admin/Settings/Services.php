<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings;

use FluentKit\Admin\UI\Fields\KeyValue;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Route;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\Service;

final class Services extends ModelSection
{
    public function __construct()
    {
        parent::__construct(Service::class);

        $this->setIcon('fa-boxes');
        $this->hide();

        $this->indexFields([
                (new Number('id', 'ID')),
                (new Route('route', 'Service'))
                    ->route('services.edit')
                    ->routeIdFrom('id')
                    ->routeLabelFrom('name'),
                (new Text('name', 'Name')),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->createFields([
                new Panel('details', 'Service Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string']),
                    (new KeyValue('credentials', 'Data', 'Enter the key/value pairs required for this service.')),
                ]),
            ])
            ->editFields([
                new Panel('details', 'Service Details', '', [
                    (new Text('name', 'Name'))->rules(['required', 'string']),
                    (new KeyValue('credentials', 'Data', 'Enter the key/value pairs required for this service.')),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ]),
            ]);

        $this->getScreen('index')->searchable(['id', 'name']);
    }
}
