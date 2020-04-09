<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Fields\Traits\SavesModelAttributes;

class Text extends Field
{
    use SavesModelAttributes;

    protected ?string $component = 'fk-admin-field-input';

    protected array $defaultRules = ['nullable', 'string'];
}
