<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields;

use FluentKit\Admin\UI\Fields\Traits\FieldsSavesModelAttributes;
use FluentKit\Admin\UI\ScreenInterface;
use FluentKit\Admin\UI\Traits\HasFields;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

final class Group extends Field
{
    use HasFields, FieldsSavesModelAttributes;

    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['fields'] = $this->getFields($request);

        return $data;
    }

    public function addValidationLabels(Validator $validator, Request $request, ScreenInterface $screen): Validator
    {
        foreach ($this->fields as $field) {
            $validator = $field->addValidationLabels($validator, $request, $screen);
        }

        return $validator;
    }

    public function addValidationRules(Validator $validator, Request $request, ScreenInterface $screen): Validator
    {
        foreach ($this->fields as $field) {
            $validator = $field->addValidationRules($validator, $request, $screen);
        }

        return $validator;
    }
}
