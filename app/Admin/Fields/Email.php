<?php

declare(strict_types=1);

namespace FluentKit\Admin\Fields;

final class Email extends Field
{
    public const FIELD_TYPE = 'email';

    protected array $defaultRules = ['email'];
}