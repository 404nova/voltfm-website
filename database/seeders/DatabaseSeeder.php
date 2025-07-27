<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the role seeder first
        $this->call(RoleSeeder::class);
        
        // Call the permission seeder to create permissions and assign them to roles
        $this->call(PermissionSeeder::class);

        // User::factory(10)->create();

        // Create admin user with admin role
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@voltfm.nl',
            'role_id' => \App\Models\Role::where('name', 'admin')->first()->id,
        ]);

        // Create test user with standard role
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => \App\Models\Role::where('name', 'user')->first()->id,
        ]);
    }
}
