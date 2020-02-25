<?php

declare(strict_types=1);

namespace FluentKit;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait LinkedToApp
{
    public static function bootLinkedToApp()
    {
        static::addGlobalScope('app', function (Builder $query) {
            $query->where(function (Builder $query) {
                $id = App::current()->id;
                $query->where('app_id', $id)
                    ->orWhereNull('app_id');
            });
        });

        static::saving(function (Model $model) {
            if (!$model->isDirty('app_id') && $model->getOriginal('app_id', false) === false) {
                $model->app_id = App::current()->id;
            }
        });
    }

    public function app()
    {
        return $this->hasOne(App::class);
    }
}
