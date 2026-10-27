<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      // Roles
Role::firstOrCreate(['name' => 'Admin']);
Role::firstOrCreate(['name' => 'Staff']);
Role::firstOrCreate(['name' => 'SuperAdmin']);

// Admin User
$admin = User::firstOrCreate(
    ['email' => 'test@example.com'], // ابحث عن هذا البريد
    [
        'name' => 'Admin User',
        'password' => bcrypt('12345678'),
    ] // إذا لم تجده، أنشئه بهذه البيانات
);
$admin->assignRole('Admin');

// Staff User
$staff = User::firstOrCreate(
    ['email' => 'staff@example.com'],
    [
        'name' => 'Staff User',
        'password' => bcrypt('12345678'),
    ]
);
$staff->assignRole('Staff');

// Super Admin User
$superAdmin = User::firstOrCreate(
    ['email' => 'ayhambsmar@gmail.com'],
    [
        'name' => 'Ayham Bsmar',
        'password' => bcrypt('12345678'),
    ]
);
$superAdmin->assignRole('SuperAdmin');
    }
}
