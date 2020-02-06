<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\FieldInterface;
use FluentKit\Admin\UI\Fields\Traits\FieldsSavesModelAttributes;
use FluentKit\Admin\UI\Traits\HasFields;
use Illuminate\Http\Request;

final class Panel extends Field
{
    use HasFields, FieldsSavesModelAttributes;

    public function __construct(string $id, string $label, string $description = '', array $fields = [])
    {
        parent::__construct($id, $label, $description);

        foreach ($fields as $field) {
            $this->addField($field);
        }
    }

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
