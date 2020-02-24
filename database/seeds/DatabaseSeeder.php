<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roles = factory(\FluentKit\Role::class, 10)->create()->each(function (\FluentKit\Role $role) {
            $permissions = factory(\FluentKit\Permission::class, 5)->create();
            $role->permissions()->sync($permissions->pluck('id'));
        });
        factory(\FluentKit\User::class, 50)->create()->each(function (\FluentKit\User $user) use ($roles) {
            $user->roles()->sync($roles->random(rand(0, 3))->pluck('id'));
        });
    }
}
