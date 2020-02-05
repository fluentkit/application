<?php

declare(strict_types=1);

namespace FluentKit\Admin\Apps;

use FluentKit\Admin\UI\Fields\Checkbox;
use FluentKit\Admin\UI\Fields\HasMany;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\AppDomain;

final class AppDomains extends ModelSection
{
    public function __construct()
    {
        parent::__construct(AppDomain::class);

        $this->setIcon('fa-globe');
        $this->hide();

        $this->with(['app']);

        $this->indexFields([
                (new Number('id', 'ID')),
                new Text('domain', 'Domain'),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->createFields([
                new Panel('details', 'Domain Details', '', [
                    (new Text('domain', 'Domain'))->rules(['required', 'string', 'unique:app_domains,domain']),
                ]),
            ])
            ->editFields([
                new Panel('details', 'App Details', '', [
                    (new Text('domain', 'Domain'))->rules(['required', 'string', 'unique:app_domains,domain,{$id}']),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ])
            ]);

        $this->getScreen('index')->searchable(['id', 'domain']);
    }
}
