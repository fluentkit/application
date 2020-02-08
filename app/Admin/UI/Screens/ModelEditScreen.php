<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\CallbackAction;
use FluentKit\Admin\UI\Actions\ModalAction;
use FluentKit\Admin\UI\Actions\ModalCloseAction;
use FluentKit\Admin\UI\Actions\SaveAction;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasModel;
use FluentKit\Admin\UI\Traits\LoadsRelations;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ModelEditScreen extends FormScreen implements ScreenInterface
{
    use HasModel, LoadsRelations;

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
            (new ModalAction('delete', 'Delete ' . $this->getModelLabel()))
                ->setMeta('button.type', 'danger')
                ->setMeta('button.icon', 'fa-trash')
                ->setMeta('modal.title', 'Are you sure?')
                ->setMeta('modal.size', 'sm')
                ->setMeta(
                    'modal.body',
                    '<p class="text-center">Please confirm deletion of '.$this->getModelLabel().' ID: <strong>{{ attributes.id }}</strong>.</p><p class="text-center text-danger uppercase"><strong>This action cannot be reversed.</strong></p>'
                )
                ->disable(fn (Request $request) => $request->get('id') === $request->user()->id)
                ->addAction(new ModalCloseAction('cancel', 'Cancel'))
                ->addAction(
                    (new CallbackAction('confirm', 'Delete ' . $this->getModelLabel()))
                        ->setMeta('button.type', 'danger')
                        ->setMeta('button.icon', 'fa-trash')
                        ->callback([$this, 'deleteModel'])
                )
        );
    }

    public function getAttributes(Request $request): array
    {
        return $this->newModelQuery()->with($this->getWith($request))->findOrFail($request->get('id'))->toArray();
    }

    public function updateModel(Request $request): ResponseInterface
    {
        $model = $this->newModelQuery()->with($this->getWith($request))->findOrFail($request->get('id'));
        foreach ($this->fields as $field) {
            $model = $field->saveAttributes($model, $request);
        }
        $model->push();

        return Notification::success($this->getModelLabel() . ' Saved!')->reloads(['attributes']);
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
