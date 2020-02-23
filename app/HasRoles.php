<?php

declare(strict_types=1);

namespace FluentKit;

use Illuminate\Database\Eloquent\Model;

trait HasRoles
{
    public static function bootHasRoles()
    {
        static::deleting(function (Model $model) {
            // As roles for models are morphable we cant rely on the db constraints
            // to delete the relationship.
            $model->roles()->detach();
        });
    }

    public function roles()
    {
        return $this->morphToMany(
            Role::class, 'model', 'model_roles', 'model_id', 'role_id'
        );
    }
}
