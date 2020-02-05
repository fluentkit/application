<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\SaveAction;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasModel;
use FluentKit\Admin\UI\Traits\LoadsRelations;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ModelCreateScreen extends FormScreen implements ScreenInterface
{
    use HasModel, LoadsRelations;

    public function __construct(string $model)
    {
        $this->setModel($model);
        $this->setId('create');
        $this->setLabel('Add New');

        $this->addAction(
            (new SaveAction('create', 'Create ' . $this->getModelLabel()))
                ->callback([$this, 'createModel'])
        );
    }

    public function getAttributes(Request $request): array
    {
        return $this->newModelInstance()->toArray();
    }

    public function createModel(Request $request): ResponseInterface
    {
        $fields = $this->getFieldKeys($request);
        $model = $this->newModelInstance();
        $attributes = Arr::only($request->get('attributes'), $fields);

        $model->fill($attributes);
        $model->push();

        $request->merge(['id' => $model->id]);

        return Redirect::route(
            $this->getModelRoute('edit'),
            ['id' => $model->id],
            Notification::success($this->getModelLabel() . ' Created!')
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
