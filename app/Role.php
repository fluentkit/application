<?php

namespace FluentKit;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use LinkedToApp;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'app_id',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'model', 'model_roles', 'role_id', 'model_id');
    }

    public function hasPermissionTo($permission): bool
    {
        if (is_string($permission)) {
            $permission = $this->permissions->firstWhere('name', $permission);
        } else {
            $permission = $this->permissions->find($permission);
        }

        return $permission instanceof Permission;
    }
}
