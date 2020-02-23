<?php

declare(strict_types=1);

namespace FluentKit;

use Illuminate\Database\Eloquent\Model;

trait HasPermissions
{
    public static function bootHasPermissions()
    {
        static::deleting(function (Model $model) {
            // As permissions for models are morphable we cant rely on the db constraints
            // to delete the relationship.
            $model->permissions()->detach();
        });
    }

    public function permissions()
    {
        return $this->morphToMany(
            Permission::class, 'model', 'model_permissions', 'model_id', 'permission_id'
        );
    }

    public function hasPermissionTo($requestedPermission): bool
    {
        if (is_string($requestedPermission)) {
            $permission = $this->permissions->firstWhere('name', $requestedPermission);
        } else {
            $permission = $this->permissions->find($requestedPermission);
        }

        if ($permission instanceof Permission) {
            return true;
        }

        if (method_exists($this, 'roles')) {
            $this->loadMissing('roles.permissions');
            foreach ($this->roles as $role) {
                if ($role->name === 'superAdmin' || $role->hasPermissionTo($requestedPermission)) {
                    return true;
                }
            }
        }

        return false;
    }
}
