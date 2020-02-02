<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use FluentKit\Admin\UI\Screens\ModelIndexScreen;
use FluentKit\Admin\UI\Screens\ModelScreen;
use FluentKit\Admin\UI\Traits\HasFields;
use Illuminate\Support\Str;

class ModelSection extends Section
{
    use HasFields;

    public function __construct(string $model, array $fields = [])
    {
        $this->setId(Str::plural(Str::snake(class_basename($model))));
        $this->setLabel(Str::plural(class_basename($model)));

        $this->registerIndex($model, $fields['index']);
        $this->registerCreate($model, $fields['create']);
        $this->registerEdit($model, $fields['edit']);
    }

    private function registerIndex(string $model, array $fields)
    {
        $screen = new ModelIndexScreen($model);

        foreach ($fields as $field) {
            $screen->addField($field->readOnly());
        }

        $this->registerScreen($screen);
    }

    private function registerCreate(string $model, array $fields)
    {
        $screen = new ModelScreen('create', $model);

        foreach ($fields as $field) {
            $screen->addField($field);
        }

        $this->registerScreen($screen);
    }

    private function registerEdit(string $model, array $fields)
    {
        $screen = new ModelScreen('edit', $model);

        foreach ($fields as $field) {
            $screen->addField($field);
        }

        $this->registerScreen($screen);
    }
}
