<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'SuperAdmin',
            'nickname' => 'superAdmin',
            'role' => 'super_admin',
            'password' => Hash::make('password'),
            'foundation_id' => null,
            'avatar_id' => null
        ]);
    }
}
