<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'low_stock_threshold' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
