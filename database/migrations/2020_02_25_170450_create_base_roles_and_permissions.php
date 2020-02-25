<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBaseRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'];
        $resources = ['app', 'appDomain', 'role', 'permission', 'user'];
        $now = now();

        DB::table('roles')->insert([
            ['name' => 'superAdmin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'administrator', 'created_at' => $now, 'updated_at' => $now]
        ]);

        $perms = [ ['name' => 'admin.view', 'created_at' => $now, 'updated_at' => $now] ];
        foreach ($resources as $resource) {
            foreach ($permissions as $permission) {
                $perms[] = ['name' => $resource.'.'.$permission, 'created_at' => $now, 'updated_at' => $now];
            }
        }
        DB::table('permissions')->insert($perms);

        $adminRoleId = DB::table('roles')->where('name', 'administrator')->value('id');
        $ids = DB::table('permissions')
            ->where('name', 'not like', 'app%')
            ->pluck('id')
            ->map(function ($id) use ($adminRoleId) {
                return [
                    'permission_id' => $id,
                    'role_id' => $adminRoleId
                ];
            })
            ->values()
            ->toArray();

        DB::table('role_permissions')->insert($ids);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('model_permissions')->truncate();
        DB::table('model_roles')->truncate();
        DB::table('role_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
    }
}
