<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Symfony\Component\Clock\now;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
    'name'=> 'Admin',
    'email'=> 'admin@test.com',
    'email_verified_at' => now(),
    'password'=> bcrypt('pass1234'),
    'is_admin'=> true,
        ]);
    }
}
