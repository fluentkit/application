<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasModel
{
    protected string $model = '';

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getModelBaseName(): string
    {
        return class_basename($this->model);
    }

    public function getModelLabel(): string
    {
        return ucwords(
            str_replace('_', ' ', Str::snake($this->getModelBaseName()))
        );
    }

    public function getModelPluralLabel(): string
    {
        return Str::plural($this->getModelLabel());
    }

    public function getModelRouteId(): string
    {
        return Str::plural(Str::snake($this->getModelBaseName()));
    }

    public function getModelRoute(string $route): string
    {
        return $this->getModelRouteId().'.'.$route;
    }

    public function newModelInstance(): Model
    {
        return new $this->model();
    }
}
