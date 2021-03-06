<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = [
            [
                'id' => 1,
                'user_id' => 1,
                'target_id' => 1,
                'task_title' => 'タスクテスト1',
                'period_kind' => 'DAY',
                'start_date' => '2021/2/10',
                'end_date' => '2021/2/10',
                'is_done' => false,
                'created_at' => '2021-02-13',
                'updated_at' => '2021-02-13',
            ],
        ];
 
        DB::table('tasks')->insert($tasks);
    }
}
