<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use FluentKit\Admin\UI\Screens\ModelCreateScreen;
use FluentKit\Admin\UI\Screens\ModelIndexScreen;
use FluentKit\Admin\UI\Screens\ModelEditScreen;
use FluentKit\Admin\UI\Traits\HasFields;
use FluentKit\Admin\UI\Traits\HasModel;

class ModelSection extends Section
{
    use HasFields, HasModel;

    public function __construct(string $model)
    {
        $this->setModel($model);
        $this->setId($this->getModelRouteId());
        $this->setLabel($this->getModelPluralLabel());
    }

    protected function indexFields(array $fields): self
    {
        $screen = $this->getScreen('index');
        if (!$screen) {
            $screen = new ModelIndexScreen($this->getModel());
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
            $screen = new ModelCreateScreen($this->getModel());
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
            $screen = new ModelEditScreen($this->getModel());
            $this->registerScreen($screen);
        }

        foreach ($fields as $field) {
            $screen->addField($field);
        }

        return $this;
    }
}
