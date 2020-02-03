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

    protected string $model = '';

    public function __construct(string $model)
    {
        $this->model = $model;
        $this->setId(Str::plural(Str::snake(class_basename($model))));
        $this->setLabel(Str::plural(class_basename($model)));
    }

    protected function indexFields(array $fields): self
    {
        $screen = $this->getScreen('index');
        if (!$screen) {
            $screen = new ModelIndexScreen($this->model);
            $this->registerScreen($screen);
        }

        foreach ($fields as $field) {
            $screen->addField($field->readOnly());
        }

        return $this;
    }

    protected function createFields(array $fields): self
    {
        $screen = $this->getScreen('create');
        if (!$screen) {
            $screen = new ModelScreen('create', $this->model);
            $this->registerScreen($screen);
        }

        foreach ($fields as $field) {
            $screen->addField($field);
        }

        return $this;
    }

    protected function editFields(array $fields): self
    {
        $screen = $this->getScreen('edit');
        if (!$screen) {
            $screen = new ModelScreen('edit', $this->model);
            $this->registerScreen($screen);
        }

        foreach ($fields as $field) {
            $screen->addField($field);
        }

        return $this;
    }
}
