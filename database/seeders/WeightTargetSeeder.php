<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WeightTarget;

class WeightTargetSeeder extends Seeder
{
    public function run()
    {
        WeightTarget::create([
            'user_id' => 1,
            'target_weight' => 60.0,
        ]);
    }
}
