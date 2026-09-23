<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeightLog;

class WeightLogSeeder extends Seeder
{
    public function run()
    {
        WeightLog::create([
            'user_id' => 1,
            'date' => '2026-09-20',
            'weight' => 65.5,
            'calories' => 2000,
            'exercise_time' => '00:30',
            'exercise_content' => 'ウォーキング',
        ]);
    }
}
