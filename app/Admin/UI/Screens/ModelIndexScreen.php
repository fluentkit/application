<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\EditAction;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModelIndexScreen extends Screen implements ScreenInterface
{
    protected string $type = 'model-index';

    protected string $model = '';

    public function __construct(string $model)
    {
        $this->model = $model;
        $this->setId('index');
        $this->setLabel('View All');

        $this->addAction(
            (new EditAction('edit', ''))
                ->route(Str::plural(Str::snake(class_basename($model))).'.edit')
                ->setMeta('button.type', 'transparent')
                ->setMeta('button.icon', 'fa-edit')
        );
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getModelLabel(): string
    {
        return class_basename($this->model);
    }

    public function toArray(Request $request): array
    {
        $screen = parent::toArray($request);
        $screen['model'] = $this->getModel();
        $screen['modelLabel'] = $this->getModelLabel();

        return $screen;
    }

    public function getAttributes(Request $request): array
    {
        return (new $this->model)->newQuery()->paginate()->toArray();
    }
}
