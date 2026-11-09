<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'pages.view',
            'pages.create',
            'pages.update',
            'pages.delete',
            'pages.publish',

            'menu.view',
            'menu.create',
            'menu.update',
            'menu.delete',

            'media.view',
            'media.upload',
            'media.delete',

            'seo.view',
            'seo.update',

            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            'settings.view',
            'settings.update',

            'messages.view',
            'messages.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'pages.view', 'pages.create', 'pages.update', 'pages.delete', 'pages.publish',
            'menu.view', 'menu.create', 'menu.update', 'menu.delete',
            'media.view', 'media.upload', 'media.delete',
            'seo.view', 'seo.update',
            'settings.view', 'settings.update',
            'messages.view', 'messages.delete',
        ]);

        $contentManager = Role::firstOrCreate(['name' => 'Content Manager', 'guard_name' => 'web']);
        $contentManager->givePermissionTo([
            'pages.view', 'pages.create', 'pages.update', 'pages.publish',
            'media.view', 'media.upload',
            'messages.view',
        ]);

        $menuManager = Role::firstOrCreate(['name' => 'Menu Manager', 'guard_name' => 'web']);
        $menuManager->givePermissionTo([
            'menu.view', 'menu.create', 'menu.update', 'menu.delete',
            'media.view', 'media.upload',
        ]);

        $seoManager = Role::firstOrCreate(['name' => 'SEO Manager', 'guard_name' => 'web']);
        $seoManager->givePermissionTo([
            'seo.view', 'seo.update',
            'pages.view',
            'menu.view',
        ]);
    }
}
