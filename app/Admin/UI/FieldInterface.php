<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface FieldInterface
{
    public function __construct(string $id, string $label, string $description = '');

    public function setId(string $id);

    public function setPriority(int $priority);

    public function setLabel(string $label);

    public function layout(string $layout): self;

    public function align(string $align): self;

    public function required(callable $callback): self;

    public function rules(array $rules): self;

    public function disable($disabled);

    public function readOnly($readOnly);

    public function hide($hidden = true);

    public function getId(): string;

    public function getLabel(): string;

    public function getLayout(): string;

    public function getAlign(): string;

    public function getRules(): array;

    public function getDisabled(Request $request): bool;

    public function getReadOnly(Request $request): bool;

    public function getHidden(Request $request): bool;

    public function toArray(Request $request): array;

    public function saveAttributes(Model $model, Request $request): Model;
}
