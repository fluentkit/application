<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Traits\HasFields;
use Illuminate\Http\Request;

final class Group extends Field
{
    use HasFields;

    public const FIELD_TYPE = 'group';

    protected string $component = 'fk-admin-field-group';

    public function getRules(): array
    {
        return $this->getFieldRules();
    }

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['fields'] = $this->getFields($request);

        return $data;
    }
}
