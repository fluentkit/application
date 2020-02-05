<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Fields\Traits\SavesModelAttributes;

class Text extends Field
{
    use SavesModelAttributes;

    public const FIELD_TYPE = 'text';

    protected array $defaultRules = ['string'];
}
