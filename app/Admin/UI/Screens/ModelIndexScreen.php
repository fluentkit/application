<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\CallbackAction;
use FluentKit\Admin\UI\Actions\ModalAction;
use FluentKit\Admin\UI\Actions\ModalCloseAction;
use FluentKit\Admin\UI\Actions\RouteAction;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasModel;
use FluentKit\Admin\UI\Traits\LoadsRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ModelIndexScreen extends Screen implements ScreenInterface
{
    use HasModel, LoadsRelations;

    protected string $type = 'model-index';

    protected array $searchableColumns = ['id'];

    public function __construct(string $model)
    {
        $this->setModel($model);
        $this->setId('index');
        $this->setLabel('View All');

        $this->disable($this->getModelPermissionName('viewAny'));

        $this->addAction(
            (new RouteAction('create', 'Add ' . $this->getModelLabel()))
                ->route($this->getModelRoute('create'))
                ->disable($this->getModelPermissionName('create'))
        );

        $this->addAction(
            (new RouteAction('edit', ''))
                ->route($this->getModelRoute('edit'), ['id'])
                ->location('table')
                ->disable($this->getModelPermissionName('update'))
                ->setMeta('button.type', 'info')
                ->setMeta('button.icon', 'fa-pencil-alt')
        );

        $this->addAction(
            (new ModalAction('delete', ''))
                ->location('table')
                ->disable($this->getModelPermissionName('delete'))
                ->setMeta('button.type', 'danger')
                ->setMeta('button.icon', 'fa-trash')
                ->setMeta('modal.title', 'Are you sure?')
                ->setMeta('modal.size', 'sm')
                ->setMeta(
                    'modal.body',
                    '<p class="text-center">Please confirm deletion of '.$this->getModelLabel().' ID: <strong>{{ id }}</strong>.</p><p class="text-center text-danger uppercase"><strong>This action cannot be reversed.</strong></p>'
                )
                ->disable($this->getModelPermissionName('delete'))
                ->addAction(new ModalCloseAction('cancel', 'Cancel'))
                ->addAction(
                    (new CallbackAction('confirm', 'Delete ' . $this->getModelLabel()))
                        ->setMeta('button.type', 'danger')
                        ->setMeta('button.icon', 'fa-trash')
                        ->callback([$this, 'deleteModel'])
                )
        );
    }

    public function searchable(array $columns = ['id']): self
    {
        $this->searchableColumns = $columns;

        return $this;
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
        return $this->newModelInstance()
            ->newQuery()
            ->with($this->getWith($request))
            ->when($request->get('search', '') !== '', function (Builder $query) use ($request) {
                foreach ($this->searchableColumns as $column) {
                    $query = $query->orWhere($column, 'like', '%'.$request->get('search').'%');
                }

                return $query;
            })
            ->paginate()
            ->toArray();
    }

    public function deleteModel(Request $request, ScreenInterface $screen): ResponseInterface
    {
        ($this->newModelInstance())->newQuery()->where('id', $request->get('id'))->delete();

        return Notification::success($this->getModelLabel() . ' Deleted!')
            ->reloads(['attributes']);
    }
}
