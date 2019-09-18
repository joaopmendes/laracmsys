<?php

use App\Language;
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
        // USERS AND PERMISSIONS
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
            'edit_status post',

            'add file',
            'list file',
            'destroy file',
            'edit file',

            'add article',
            'list article',
            'destroy article',
            'edit article',

            'add language',
            'list language',
            'destroy language',
            'edit language',
            'edit_status language',
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        User::create([
            'name' => 'Admin',
            'email' => 'administrator@admin.com',
            'password' => bcrypt('admin123'),
        ])->syncPermissions(Permission::all()->pluck('name'));;
        User::create([
            'name' => 'testing',
            'email' => 'teste@admin.com',
            'password' => bcrypt('admin123'),
        ])->syncPermissions("backoffice access","add user");
        // -----------------------------

        // LANGUAGES
        Language::create([
            'slug' => 'EN',
            'name' => 'English',
        ]);
        // -------------

    }
}
