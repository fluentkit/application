<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

final class Number extends Text
{
    protected array $defaultRules = ['nullable', 'numeric'];
}
