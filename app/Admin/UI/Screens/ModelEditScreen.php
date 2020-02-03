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
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ModelEditScreen extends FormScreen implements ScreenInterface
{
    use HasModel;

    public function __construct(string $model)
    {
        $this->routeParams = [':id'];
        $this->setModel($model);
        $this->setId('edit');
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

    public function getAttributes(Request $request): array
    {
        return $this->newModelQuery()->findOrFail($request->get('id'))->attributesToArray();
    }

    public function updateModel(Request $request): ResponseInterface
    {
        $fields = $this->getFieldKeys($request);
        $model = $this->newModelQuery()->findOrFail($request->get('id'));
        $forUpdate = Arr::only($request->get('attributes'), $fields);

        $model->fill($forUpdate);
        $model->save();

        return Notification::success($this->getModelLabel() . ' Saved!');
    }

    public function deleteModel(Request $request): ResponseInterface
    {
        $this->newModelQuery()->where('id', $request->get('id'))->delete();

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
