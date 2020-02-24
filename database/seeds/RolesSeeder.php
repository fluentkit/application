<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'forceDelete'
        ];
        $resources = [
            \FluentKit\App::class,
            \FluentKit\AppDomain::class,
            \FluentKit\Role::class,
            \FluentKit\Permission::class,
            \FluentKit\User::class,
        ];

        $superAdmin = \FluentKit\Role::create(['name' => 'superAdmin']);
        $administrator = \FluentKit\Role::create(['name' => 'administrator']);

        $allPermissionIds = [];

        foreach ($resources as $resource) {
            $name = \Illuminate\Support\Str::camel(class_basename($resource));
            foreach ($permissions as $permission) {
                $permission = \FluentKit\Permission::create(['name' => $name.'.'.$permission]);
                if (!in_array($resource, [\FluentKit\App::class, \FluentKit\AppDomain::class])) {
                    $allPermissionIds[] = $permission->id;
                }
            }
        }

        $administrator->permissions()->sync($allPermissionIds);
    }
}
