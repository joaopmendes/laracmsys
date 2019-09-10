<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'backoffice access',

            // User permissions
            'add user',
            'list user',
            'edit user',
            'destroy user',
            'assign permission',

            // Permissions
            'add permission',
            'list permission',
            'destroy permission',
            'edit permission'

        ];
        // create permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        // create roles and assign created permissions

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $user_admin = User::create([
                            'name' => 'Admin',
                            'email' => 'administrator@admin.com',
                            'password' => bcrypt('admin123'),
                        ]);
        $user_normal = User::create([
            'name' => 'testing',
            'email' => 'teste@admin.com',
            'password' => bcrypt('admin123'),
        ]);
        $user_normal->givePermissionTo('backoffice access','list permission');
        // Assign the role to the admin user
        $user_admin->assignRole($role);
    }
}
