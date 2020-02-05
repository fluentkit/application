<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Fields\Traits\SavesModelAttributes;

final class Email extends Field
{
    use SavesModelAttributes;

    public const FIELD_TYPE = 'email';

    protected array $defaultRules = ['email'];
}
