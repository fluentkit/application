<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\ScreenInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

abstract class ModelScreen extends FormScreen implements ScreenInterface
{
    protected string $model = '';

    protected array $routeParams = [':id'];

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
        $model = $this->getQuery()->findOrFail($request->get('id'));
        return $model->attributesToArray();
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
