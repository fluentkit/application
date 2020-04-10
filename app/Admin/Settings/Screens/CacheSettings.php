<?php

declare(strict_types=1);

namespace FluentKit\Admin\Settings\Screens;

use FluentKit\Admin\UI\Fields\Checkbox;
use FluentKit\Admin\UI\Fields\Panel;
use FluentKit\Admin\UI\Fields\Select;
use FluentKit\Admin\UI\Fields\Text;
use FluentKit\Admin\UI\Screens\SettingScreen;
use FluentKit\Role;

final class CacheSettings extends SettingScreen
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('cache');
        $this->setLabel('Cache Settings');

        $this->addField(
            (new Panel('cache', 'Cache Settings', ''))
                ->addField(
                    (new Select('default', 'Cache Driver', 'Choose one of the available cache drivers. The <code>array</code> is for debugging purposes only suppresses caching.'))
                        ->options([
                            ['id' => 'database', 'label' => trans('Database')],
                            ['id' => 'file', 'label' => trans('File')],
                            ['id' => 'apc', 'label' => trans('APC')],
                            ['id' => 'array', 'label' => trans('Array')]
                        ])
                        ->rules(['required'])
                )
            ->addField(
                (new Text('prefix', 'Cache Prefix', 'Please ensure your terminate the prefix with an underscore <code>_</code>.'))
                    ->rules(['required', 'string', 'ends_with:_'])
            )
        );
    }
}
