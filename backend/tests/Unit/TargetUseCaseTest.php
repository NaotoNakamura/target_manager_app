<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use packages\Domain\Target;
use packages\Infrastructure\TargetRepository;
use packages\UseCase\TargetIndexUseCase;
use packages\UseCase\TargetShowUseCase;
use packages\UseCase\TargetStoreUseCase;
use packages\UseCase\TargetUpdateUseCase;
use packages\UseCase\TargetDestroyUseCase;
use Illuminate\Support\Facades\Artisan;

class TargetUseCaseTest extends TestCase
{
    use RefreshDatabase;
    private $targetRepository;
    private $targetIndexUseCase;
    private $targetShowUseCase;
    private $targetStoreUseCase;
    private $targetUpdateUseCase;
    private $targetDestroyUseCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
        $this->seed('TargetsTableSeeder');
        $this->seed('TasksTableSeeder');
        $this->targetRepository = new TargetRepository();
        $this->targetIndexUseCase = new TargetIndexUseCase($this->targetRepository);
        $this->targetShowUseCase = new TargetShowUseCase($this->targetRepository);
        $this->targetStoreUseCase = new TargetStoreUseCase($this->targetRepository);
        $this->targetUpdateUseCase = new TargetUpdateUseCase($this->targetRepository);
        $this->targetDestroyUseCase = new TargetDestroyUseCase($this->targetRepository);
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }

    public function test_index(){
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
        $result = $this->targetIndexUseCase->handle(1);
        $this->assertEquals($expected, $result[0]);
    }

    public function test_show(){
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
        $result = $this->targetShowUseCase->handle(1, 1);
        $this->assertEquals($expected, $result);
    }

    public function test_store(){
        $request = [
            "id" => null,
            "target_title" => "showUseCaseテスト",
            "tasks" => [],
        ];
        $this->targetStoreUseCase->handle($request, 1);
        $this->assertDatabaseHas('targets', [
            'target_title' => "showUseCaseテスト"
        ]);
    }

    public function test_update(){
        $request = [
            "target_title" => "updateUseCaseテスト",
            "tasks" => [],
        ];
        $this->targetUpdateUseCase->handle(1, 1, $request);
        $this->assertDatabaseHas('targets', [
            'target_title' => "updateUseCaseテスト"
        ]);
    }

    public function test_destroy(){
        $this->targetDestroyUseCase->handle(1, 1);
        $this->assertDatabaseMissing('targets', [
            'id' => 1
        ]);
    }
}
