<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // テストユーザー（ID: 1）を作成
        User::create([
            'id' => 1,
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // 各シーダーの呼び出し
        $this->call([
            WeightLogSeeder::class,
            WeightTargetSeeder::class,
        ]);
    }
}
