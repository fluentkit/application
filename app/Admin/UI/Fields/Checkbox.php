<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Fields\Traits\SavesModelAttributes;

class Checkbox extends Field
{
    use SavesModelAttributes;

    public const FIELD_TYPE = 'checkbox';

    protected string $component = 'fk-admin-field-checkbox';

    public function __construct(string $id, string $label, string $description = '')
    {
        parent::__construct($id, $label, $description);

        $this->setMeta('checkbox.label', null);
    }
}
