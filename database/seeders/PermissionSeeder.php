<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissionGroups = [
            // Content Management Permissions
            'news' => [
                'view news' => 'Bekijk nieuwsberichten',
                'create news' => 'Maak nieuwsberichten aan',
                'edit news' => 'Bewerk nieuwsberichten',
                'delete news' => 'Verwijder nieuwsberichten',
            ],
            'categories' => [
                'view categories' => 'Bekijk categorieën',
                'create categories' => 'Maak categorieën aan',
                'edit categories' => 'Bewerk categorieën',
                'delete categories' => 'Verwijder categorieën',
            ],
            'tags' => [
                'view tags' => 'Bekijk tags',
                'create tags' => 'Maak tags aan',
                'edit tags' => 'Bewerk tags',
                'delete tags' => 'Verwijder tags',
            ],
            'comments' => [
                'view comments' => 'Bekijk commentaren',
                'moderate comments' => 'Modereer commentaren',
                'delete comments' => 'Verwijder commentaren',
            ],
            // DJ schedule permissions
            'dj schedule' => [
                'view dj schedule' => 'Bekijk DJ planning',
                'manage own availability' => 'Beheer eigen beschikbaarheid',
                'manage all availability' => 'Beheer alle beschikbaarheid',
                'assign djs' => 'Wijs DJs toe aan programma\'s',
            ],
            // Programs permissions
            'programs' => [
                'view programs' => 'Bekijk programma\'s',
                'create programs' => 'Maak programma\'s aan',
                'edit programs' => 'Bewerk programma\'s',
                'delete programs' => 'Verwijder programma\'s',
            ],
            // Song requests permissions
            'song requests' => [
                'view requests' => 'Bekijk verzoeknummers',
                'process requests' => 'Verwerk verzoeknummers',
                'delete requests' => 'Verwijder verzoeknummers',
            ],
            // User management permissions
            'users' => [
                'view users' => 'Bekijk gebruikers',
                'create users' => 'Maak gebruikers aan',
                'edit users' => 'Bewerk gebruikers',
                'delete users' => 'Verwijder gebruikers',
            ],
        ];

        // Create permissions
        foreach ($permissionGroups as $group => $permissions) {
            foreach ($permissions as $name => $description) {
                Permission::firstOrCreate([
                    'slug' => Str::slug($name),
                ], [
                    'name' => $name,
                    'description' => $description,
                ]);
            }
        }

        // Ensure roles exist
        $roles = [
            'admin' => 'Administrator met volledige rechten',
            'beheer' => 'Beheerder met uitgebreide rechten',
            'redactie' => 'Redactielid met toegang tot content',
            'dj' => 'DJ met toegang tot programma\'s',
            'marketing' => 'Marketing met beperkte rechten',
        ];

        foreach ($roles as $name => $description) {
            Role::firstOrCreate([
                'name' => $name,
            ], [
                'description' => $description,
            ]);
        }

        // Assign permissions to roles
        $rolePermissions = [
            'admin' => Permission::all()->pluck('id')->toArray(),
            'beheer' => Permission::whereIn('slug', [
                'view-news', 'create-news', 'edit-news', 'delete-news',
                'view-categories', 'create-categories', 'edit-categories', 'delete-categories',
                'view-tags', 'create-tags', 'edit-tags', 'delete-tags',
                'view-comments', 'moderate-comments', 'delete-comments',
                'view-dj-schedule', 'manage-own-availability', 'manage-all-availability', 'assign-djs',
                'view-programs', 'create-programs', 'edit-programs', 'delete-programs',
                'view-requests', 'process-requests', 'delete-requests',
                'view-users', 'edit-users',
            ])->pluck('id')->toArray(),
            'redactie' => Permission::whereIn('slug', [
                'view-news', 'create-news', 'edit-news',
                'view-categories', 'create-categories', 'edit-categories',
                'view-tags', 'create-tags', 'edit-tags',
                'view-comments', 'moderate-comments',
            ])->pluck('id')->toArray(),
            'dj' => Permission::whereIn('slug', [
                'view-dj-schedule', 'manage-own-availability',
                'view-programs',
                'view-requests', 'process-requests',
            ])->pluck('id')->toArray(),
            'marketing' => Permission::whereIn('slug', [
                'view-news', 'create-news', 'edit-news',
                'view-categories',
                'view-tags',
            ])->pluck('id')->toArray(),
        ];

        foreach ($rolePermissions as $roleName => $permissionIds) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->permissions()->sync($permissionIds);
            }
        }
    }
}
