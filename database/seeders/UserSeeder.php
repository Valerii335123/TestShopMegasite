<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    private const ADMIN_EMAIL = 'admin@admin.admin';

    public function run(): void
    {
        if (User::where('email', self::ADMIN_EMAIL)->doesntExist()) {
            User::factory()->create([
                'name' => 'Admin',
                'password' => 'password',
                'email' => self::ADMIN_EMAIL,
            ]);
        }
    }
}
