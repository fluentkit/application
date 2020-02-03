<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\DeleteAction;
use FluentKit\Admin\UI\Actions\SaveAction;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ModelScreen extends FormScreen implements ScreenInterface
{
    use HasModel;

    protected string $context = 'create';

    public function __construct(string $context, string $model)
    {
        $this->context = $context;
        $this->setModel($model);
        $this->setId($context);

        if ($context === 'create') {
            $this->setLabel('Add New');
            $this->addAction(
                (new SaveAction('create', 'Create ' . $this->getModelLabel()))
                    ->callback([$this, 'createModel'])
            );
        } elseif ($context === 'edit') {
            $this->routeParams = [':id'];
            $this->setLabel('Edit ' . $this->getModelLabel());
            $this->hide();
            $this->addAction(
                (new SaveAction('update', 'Update ' . $this->getModelLabel()))
                    ->callback([$this, 'updateModel'])
            );
            $this->addAction(
                (new DeleteAction('delete', 'Delete ' . $this->getModelLabel()))
                    ->setMeta('modal.body', 'Please click to the ' . $this->getModelLabel() . ' with ID: {{ attributes.id }}. This action is desctructive.')
                    ->setMeta('modal.confirm.label', 'Delete ' . $this->getModelLabel())
                    ->callback([$this, 'deleteModel'])
                    ->disable(fn (Request $request) => $request->get('id') === $request->user()->id)
            );
        }
    }

    protected function getQuery(): Builder
    {
        return $this->newModelInstance()->newQuery();
    }

    public function getAttributes(Request $request): array
    {
        if ($this->context === 'create') {
            $model = $this->newModelInstance();
        } else {
            $model = $this->getQuery()->findOrFail($request->get('id'));
        }

        return $model->attributesToArray();
    }

    public function createModel(Request $request): ResponseInterface
    {
        $fields = $this->getFieldKeys($request);
        $model = $this->newModelInstance();
        $forUpdate = Arr::only($request->get('attributes'), $fields);

        $model->fill($forUpdate);
        $model->save();

        $request->merge(['id' => $model->id]);

        return Redirect::route(
            $this->getModelRoute('edit'),
            ['id' => $model->id],
            Notification::success($this->getModelLabel() . ' Created!')
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

    public function deleteModel(Request $request): ResponseInterface
    {
        $this->getQuery()->where('id', $request->get('id'))->delete();

        return Redirect::route(
            $this->getModelRoute('index'),
            [],
            Notification::success($this->getModelLabel() . ' Deleted!')
        );
    }

    public function toArray(Request $request): array
    {
        $screen = parent::toArray($request);
        $screen['model'] = $this->getModel();
        $screen['modelLabel'] = $this->getModelLabel();
        $screen['modelPluralLabel'] = $this->getModelPluralLabel();

        return $screen;
    }
}
