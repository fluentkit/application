<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\DeleteAction;
use FluentKit\Admin\UI\Actions\EditAction;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
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
                ->setMeta('button.type', 'info')
                ->setMeta('button.icon', 'fa-pencil-alt')
        );

        $this->addAction(
            (new DeleteAction('delete', ''))
                ->setMeta('modal.body', 'Please click to the '.class_basename($model).' with ID: {{ id }}. This action is desctructive.')
                ->setMeta('modal.confirm.label', 'Delete User')
                ->callback([$this, 'deleteModel'])
                ->disable(fn (Request $request) => $request->get('id') === $request->user()->id)
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
        $screen['modelPluralLabel'] = Str::plural($this->getModelLabel());

        return $screen;
    }

    public function getAttributes(Request $request): array
    {
        return (new $this->model)->newQuery()->paginate()->toArray();
    }

    public function deleteModel(Request $request, ScreenInterface $screen): ResponseInterface
    {
        (new $this->model)->newQuery()->where('id', $request->get('id'))->delete();

        return Redirect::route(
            Str::plural(Str::snake(class_basename($this->model))).'.index',
            [],
            Notification::success($this->getModelLabel() . ' Deleted!')
        );
    }
}
