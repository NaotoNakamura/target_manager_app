<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $targets = [
            [
                'id' => 1,
                'user_id' => 1,
                'target_title' => '目標テスト1',
                'created_at' => '2021-02-13',
                'updated_at' => '2021-02-13',
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'target_title' => '目標テスト2',
                'created_at' => '2021-02-13',
                'updated_at' => '2021-02-13',
            ],
        ];

        DB::table('targets')->insert($targets);
    }
}
