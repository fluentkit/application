<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Fields\Traits\SavesModelAttributes;
use Illuminate\Http\Request;

class Select extends Field
{
    use SavesModelAttributes;
    
    public const FIELD_TYPE = 'select';

    public string $component = 'fk-admin-field-select';

    protected $options = [];

    public function options($options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions(Request $request): array
    {
        return is_callable($this->options) ? call_user_func($this->options, $request) : $this->options;
    }

    public function toArray(Request $request): array
    {
        $field = parent::toArray($request);
        $field['options'] = $this->getOptions($request);

        return $field;
    }
}
