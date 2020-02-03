<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Screens;

use FluentKit\Admin\UI\Actions\DeleteAction;
use FluentKit\Admin\UI\Actions\RouteAction;
use FluentKit\Admin\UI\ResponseInterface;
use FluentKit\Admin\UI\Responses\Notification;
use FluentKit\Admin\UI\Responses\Redirect;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ModelIndexScreen extends Screen implements ScreenInterface
{
    use HasModel;

    protected string $type = 'model-index';

    protected array $searchableColumns = ['id'];

    public function __construct(string $model)
    {
        $this->setModel($model);
        $this->setId('index');
        $this->setLabel('View All');

        $this->addAction(
            (new RouteAction('create', 'Add ' . $this->getModelLabel()))
                ->route($this->getModelRoute('create'))
        );

        $this->addAction(
            (new RouteAction('edit', ''))
                ->route($this->getModelRoute('edit'), ['id'])
                ->location('table')
                ->setMeta('button.type', 'info')
                ->setMeta('button.icon', 'fa-pencil-alt')
        );

        $this->addAction(
            (new DeleteAction('delete', ''))
                ->location('table')
                ->setMeta(
                    'modal.body',
                    '<p class="text-center">Please confirm deletion of '.$this->getModelLabel().' ID: <strong>{{ id }}</strong>.</p><p class="text-center text-danger uppercase"><strong>This action cannot be reversed.</strong></p>'
                )
                ->setMeta('modal.confirm.label', 'Delete ' . $this->getModelLabel())
                ->callback([$this, 'deleteModel'])
                ->disable(fn (Request $request) => $request->get('id') === $request->user()->id)
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

        return Redirect::route(
            $this->getModelRoute('index'),
            [],
            Notification::success($this->getModelLabel() . ' Deleted!')
        );
    }
}
