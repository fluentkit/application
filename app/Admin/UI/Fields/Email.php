<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

final class Email extends Text
{
    protected array $defaultRules = ['email'];
}
