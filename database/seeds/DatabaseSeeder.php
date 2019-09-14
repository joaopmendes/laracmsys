<?php

use App\Post;
use App\Tag;
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
            'edit permission',


            // Tags
            'add tag',
            'list tag',
            'destroy tag',
            'edit tag',

            // Post
            'add post',
            'list post',
            'destroy post',
            'edit post',

            'add file',
            'list file',
            'destroy file',
            'edit file',

        ];
        // create permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $user_admin = User::create([
            'name' => 'Admin',
            'email' => 'administrator@admin.com',
            'password' => bcrypt('admin123'),
        ]);
        $user_admin->syncPermissions(Permission::all()->pluck('name'));
        $user_normal = User::create([
            'name' => 'testing',
            'email' => 'teste@admin.com',
            'password' => bcrypt('admin123'),
        ]);
        $user_normal->syncPermissions("backoffice access","add user");
        $this->call(PostSeeder::class);
        $this->call(TagSeeder::class);
        Post::first()->tags()->sync(Tag::all()->pluck('id'));
    }
}
