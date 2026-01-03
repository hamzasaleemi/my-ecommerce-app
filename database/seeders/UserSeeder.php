<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => config('admin.defaults.name'),
            'email' => config('admin.defaults.email'),
            'password' => bcrypt(config('admin.defaults.password')),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::factory()->count(1000)->create();
    }
}
