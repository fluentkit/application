<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

class Route extends Field
{
    public function route(string $route): self
    {
        return $this->setMeta('route.id', $route);
    }

    public function routeLabel(string $label): self
    {
        return $this->setMeta('route.label', $label);
    }

    public function routeLabelFrom(string $from): self
    {
        return $this->setMeta('route.from', $from);
    }
}
