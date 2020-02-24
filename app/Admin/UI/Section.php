<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use FluentKit\Admin\UI\Traits\CanBeDisabled;
use FluentKit\Admin\UI\Traits\CanBeHidden;
use FluentKit\Admin\UI\Traits\HasIcon;
use FluentKit\Admin\UI\Traits\HasId;
use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasPriority;
use Illuminate\Http\Request;

class Section implements SectionInterface
{
    use HasId, HasIcon, HasLabel, HasPriority, CanBeHidden, CanBeDisabled;

    protected array $screens = [];

    public function registerScreen(ScreenInterface $screen): SectionInterface
    {
        $this->screens[$screen->getId()] = $screen;

        return $this;
    }

    public function getScreen(string $id): ?ScreenInterface
    {
        return $this->screens[$id] ?? null;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'priority' => $this->getPriority(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'screens' => collect($this->screens)
                ->map(fn (ScreenInterface $screen) => $screen->toArray($request))
                ->sortBy('priority')
                ->reject(fn(array $screen) => $screen['disabled'])
                ->toArray(),
            'hidden' => $this->getHidden($request),
            'disabled' => $this->getDisabled($request),
        ];
    }
}
