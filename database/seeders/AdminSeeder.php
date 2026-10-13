<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's administrator account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@skillmatch.test',
            ],
            [
                'name' => 'SkillMatch Administrator',
                'password' => '121389100043',
                'role' => 'admin',
            ]
        );
    }
}