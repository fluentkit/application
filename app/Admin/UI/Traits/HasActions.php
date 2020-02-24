<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

use FluentKit\Admin\UI\ActionInterface;
use Illuminate\Http\Request;

trait HasActions
{
    protected array $actions = [];

    public function addAction(ActionInterface $action): self
    {
        $this->actions[$action->getId()] = $action;

        return $this;
    }

    public function getAction(string $id): ?ActionInterface
    {
        return $this->actions[$id] ?? null;
    }

    public function getActions(Request $request): array
    {
        return collect($this->actions)
            ->map(fn (ActionInterface $action) => $action->toArray($request))
            ->sortBy('priority')
            ->reject(fn (array $action) => $action['disabled'])
            ->toArray();
    }
}
