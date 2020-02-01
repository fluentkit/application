<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\SaveAction;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ModelScreen extends FormScreen implements ScreenInterface
{
    protected string $context = 'create';

    protected string $model = '';

    public function __construct(string $context, string $model)
    {
        $this->context = $context;
        $this->model = $model;
        $this->setId($context);

        if ($context === 'create') {
            $this->setLabel('Add New');
            $this->addAction(
                (new SaveAction('create', 'Create ' . class_basename($model)))
                    ->saveCallback([$this, 'createModel'])
            );
        } elseif ($context === 'edit') {
            $this->routeParams = [':id'];
            $this->setLabel('Edit ' . class_basename($model));
            $this->hide();
            $this->addAction(
                (new SaveAction('update', 'Update ' . class_basename($model)))
                    ->saveCallback([$this, 'updateModel'])
            );
        }
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

    protected function getQuery(): Builder
    {
        return (new $this->model)->newQuery();
    }

    public function getAttributes(Request $request): array
    {
        if ($this->context === 'create') {
            $model = new $this->model;
        } else {
            $model = $this->getQuery()->findOrFail($request->get('id'));
        }

        return $model->attributesToArray();
    }

    public function createModel(Request $request): ResponseInterface
    {
        $fields = $this->getFieldKeys($request);
        $model = new $this->model;
        $forUpdate = Arr::only($request->get('attributes'), $fields);

        $model->fill($forUpdate);
        $model->save();

        $request->merge(['id' => $model->id]);

        return Redirect::route(
            Str::plural(Str::snake(class_basename($model))).'.edit',
            ['id' => $model->id]
        );
    }

    public function updateModel(Request $request): ResponseInterface
    {
        $fields = $this->getFieldKeys($request);
        $model = $this->getQuery()->findOrFail($request->get('id'));
        $forUpdate = Arr::only($request->get('attributes'), $fields);

        $model->fill($forUpdate);
        $model->save();

        return Notification::success($this->getModelLabel() . ' Saved!');
    }

    public function toArray(Request $request): array
    {
        $screen = parent::toArray($request);
        $screen['model'] = $this->getModel();
        $screen['modelLabel'] = $this->getModelLabel();

        return $screen;
    }
}
