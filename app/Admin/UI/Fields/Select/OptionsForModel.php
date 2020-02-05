<?php

declare(strict_types=1);

namespace FluentKit\Admin\UI\Fields\Select;

use FluentKit\Admin\UI\Traits\HasLabel;
use FluentKit\Admin\UI\Traits\HasModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

final class OptionsForModel
{
    use HasLabel, HasModel;

    public function __construct(string $model, string $label)
    {
        $this->setModel($model);
        $this->setLabel($label);
    }

    public function __invoke(Request $request): array
    {
        return $this->getModel()::all()
            ->map(function (Model $model) {
                return [
                    'id' => $model->id,
                    'label' => $model->{$this->getLabel()},
                ];
            })
            ->sortBy('label')
            ->toArray();
    }
}
