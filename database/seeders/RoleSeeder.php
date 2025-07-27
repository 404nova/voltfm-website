<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Beheerder met volledige rechten',
            ],
            [
                'name' => 'dj',
                'description' => 'DJ met toegang tot programmering',
            ],
            [
                'name' => 'marketing',
                'description' => 'Marketing medewerker met toegang tot nieuws',
            ],
            [
                'name' => 'beheer',
                'description' => 'Beheer medewerker met beperkte toegang',
            ],
            [
                'name' => 'user',
                'description' => 'Standaard gebruiker zonder admin toegang',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
