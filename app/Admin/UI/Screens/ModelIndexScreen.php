<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\DeleteAction;
use FluentKit\Admin\UI\Actions\EditAction;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Http\Request;

class ModelIndexScreen extends Screen implements ScreenInterface
{
    use HasModel;

    protected string $type = 'model-index';

    public function __construct(string $model)
    {
        $this->setModel($model);
        $this->setId('index');
        $this->setLabel('View All');

        $this->addAction(
            (new EditAction('edit', ''))
                ->route($this->getModelRoute('edit'))
                ->setMeta('button.type', 'info')
                ->setMeta('button.icon', 'fa-pencil-alt')
        );

        $this->addAction(
            (new DeleteAction('delete', ''))
                ->setMeta('modal.body', 'Please click to the '.$this->getModelLabel().' with ID: {{ id }}. This action is desctructive.')
                ->setMeta('modal.confirm.label', 'Delete ' . $this->getModelLabel())
                ->callback([$this, 'deleteModel'])
                ->disable(fn (Request $request) => $request->get('id') === $request->user()->id)
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

    public function getAttributes(Request $request): array
    {
        return $this->newModelInstance()->newQuery()->paginate()->toArray();
    }

    public function deleteModel(Request $request, ScreenInterface $screen): ResponseInterface
    {
        ($this->newModelInstance())->newQuery()->where('id', $request->get('id'))->delete();

        return Redirect::route(
            $this->getModelRoute('index'),
            [],
            Notification::success($this->getModelLabel() . ' Deleted!')
        );
    }
}
