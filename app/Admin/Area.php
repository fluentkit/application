<?php

declare(strict_types=1);

namespace FluentKit\Admin;

use FluentKit\Admin\UI\SectionInterface;
use FluentKit\Admin\UI\UserLinkInterface;
use Illuminate\Http\Request;

final class Area
{
    private array $servingCallbacks = [];

    private array $sections = [];

    private array $userLinks = [];

    public function serving(callable $callback): self
    {
        $this->servingCallbacks[] = $callback;

        return $this;
    }

    public function serve(Request $request): void
    {
        foreach ($this->servingCallbacks as $callback) {
            $callback($this);
        }
    }

    public function registerSection(SectionInterface $screen): self
    {
        $this->sections[$screen->getId()] = $screen;

        return $this;
    }

    public function getSection(string $id): ?SectionInterface
    {
        return $this->sections[$id] ?? null;
    }

    public function registerUserLink(UserLinkInterface $link): self
    {
        $this->userLinks[$link->getId()] = $link;

        return $this;
    }

    public function getUserLink(string $id): ?UserLinkInterface
    {
        return $this->userLinks[$id] ?? null;
    }

    public function toArray(Request $request): array
    {
        return [
            'sections' => $this->getSections($request),
            'assetUrl' => asset('/'),
            'user' => request()->user(),
            'userLinks' => $this->getUserLinks($request)
        ];
    }

    private function getSections(Request $request): array
    {
        return collect($this->sections)
            ->map(fn(SectionInterface $section) => $section->toArray($request))
            ->sortBy('priority')
            ->reject(fn(array $section) => $section['disabled'])
            ->toArray();
    }

    private function getUserLinks(Request $request): array
    {
        return collect($this->userLinks)
            ->map(fn(UserLinkInterface $link) => $link->toArray($request))
            ->sortBy('priority')
            ->values()
            ->toArray();
    }
}
