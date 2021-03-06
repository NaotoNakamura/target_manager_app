<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use packages\Domain\Target;
use packages\Infrastructure\TargetRepository;
use Illuminate\Support\Facades\Artisan;

class TargetRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private $targetRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
        $this->seed('TargetsTableSeeder');
        $this->seed('TasksTableSeeder');
        $this->targetRepository = new TargetRepository();
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }

    public function test_目標一覧が取得できること()
    {
        $expected = $this->targetRepository->getAll(1);
        $result = array_map(function ($s) {
            return [
                "id" => $s->id(),
                "user_id" => $s->userId(),
                "title" => $s->title(),
                "tasks" => $s->tasks()
            ];
        }, $expected);

        $test = [
            "id" => 1,
            "user_id" => 1,
            "title" => "目標テスト1",
            "tasks" => [
                [
                    "id" => 1,
                    "user_id" => 1,
                    "target_id" => 1,
                    "task_title" => "タスクテスト1",
                    "period_kind" => "DAY",
                    "start_date" => "2021-02-10",
                    "end_date" => "2021-02-10",
                    "is_done" => 0,
                    "created_at" => "2021-02-13T00:00:00.000000Z",
                    "updated_at" =>"2021-02-13T00:00:00.000000Z"
                ]
            ]
        ];
        $this->assertEquals($test, $result[0]);
    }

    public function test_1つの目標が取得できること() {
        $result = $this->targetRepository->findById(1, 1);
        $test = [
            "id" => $result->id(),
            "user_id" => $result->userId(),
            "title" => $result->title(),
            "tasks" => $result->tasks()
        ];
        $expected = [
            "id" => 1,
            "user_id" => 1,
            "title" => "目標テスト1",
            "tasks" => [
                [
                    "id" => 1,
                    "user_id" => 1,
                    "target_id" => 1,
                    "task_title" => "タスクテスト1",
                    "period_kind" => "DAY",
                    "start_date" => "2021-02-10",
                    "end_date" => "2021-02-10",
                    "is_done" => 0,
                    "created_at" => "2021-02-13T00:00:00.000000Z",
                    "updated_at" =>"2021-02-13T00:00:00.000000Z"
                ]
            ]
        ];
        $this->assertEquals($test, $expected);
    }

    public function test_目標が作成できること(){
        $target = new Target(
            3,
            1,
            "目標テスト3",
            []
        );
        $this->targetRepository->store($target);
        $this->assertDatabaseHas('targets', [
            'target_title' => "目標テスト3"
        ]);
    }

    public function test_目標が更新できること(){
        $target = new Target(
            1,
            1,
            "更新テスト",
            []
        );
        $this->targetRepository->update($target);
        $this->assertDatabaseHas('targets', [
            'target_title' => "更新テスト"
        ]);
    }

    public function test_目標が削除できること(){
        $target = new Target(
            2,
            2,
            "目標テスト2",
            []
        );
        $this->targetRepository->destroy($target);
        $this->assertDatabaseMissing('targets', [
            'id' => 2
        ]);
    }
}
