<?php

declare(strict_types=1);

namespace FluentKit\Admin\Apps;

use FluentKit\Admin\UI\Fields\Checkbox;
use FluentKit\Admin\UI\Fields\HasMany;
use FluentKit\Admin\UI\Fields\Number;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Route;
use FluentKit\Admin\UI\Fields\Select;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\ModelSection;
use FluentKit\App;
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
                (new Route('app_id', 'App'))->route('apps.edit')->routeLabelFrom('app.name')->align('center'),
                (new Text('created_at', 'Created At')),
                (new Text('updated_at', 'Updated At'))
            ])
            ->createFields([
                new Panel('details', 'Domain Details', '', [
                    (new Text('domain', 'Domain'))->rules(['required', 'string', 'unique:app_domains,domain']),
                    (new Select('app_id', 'App'))
                        ->rules(['required', 'numeric', 'exists:apps,id'])
                        ->options(new Select\OptionsForModel(App::class, 'name')),
                ]),
            ])
            ->editFields([
                new Panel('details', 'App Details', '', [
                    (new Text('domain', 'Domain'))->rules(['required', 'string', 'unique:app_domains,domain,{$id}']),
                    (new Select('app_id', 'App'))
                        ->rules(['required', 'numeric', 'exists:apps,id'])
                        ->options(new Select\OptionsForModel(App::class, 'name')),
                    (new Text('created_at', 'Created At'))->readOnly(),
                    (new Text('updated_at', 'Updated At'))->readOnly()
                ])
            ]);

        $this->getScreen('index')->searchable(['id', 'domain']);
    }
}
