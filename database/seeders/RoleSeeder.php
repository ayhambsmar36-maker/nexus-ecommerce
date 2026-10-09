<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=[
            [
                'name' => 'Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Staff',
                'guard_name' => 'web',
            ],
            [
                'name' => 'SuperAdmin',
                'guard_name' => 'web',
            ],
        ];
        foreach ($roles as $role) {
            Role::findOrCreate($role['name'], $role['guard_name']);
        }
    }
}
