<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use packages\Domain\Task;
use packages\Infrastructure\TaskRepository;
use packages\UseCase\TaskIndexUseCase;
use packages\UseCase\TaskShowUseCase;
use packages\UseCase\TaskStoreUseCase;
use packages\UseCase\TaskUpdateUseCase;
use packages\UseCase\TaskDestroyUseCase;
use Illuminate\Support\Facades\Artisan;

class TaskUseCaseTest extends TestCase
{
    use RefreshDatabase;
    private $taskRepository;
    private $taskIndexUseCase;
    private $taskShowUseCase;
    private $taskStoreUseCase;
    private $taskUpdateUseCase;
    private $taskDestroyUseCase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
        $this->seed('TargetsTableSeeder');
        $this->seed('TasksTableSeeder');
        $this->taskRepository = new TaskRepository();
        $this->taskIndexUseCase = new TaskIndexUseCase($this->taskRepository);
        $this->taskShowUseCase = new TaskShowUseCase($this->taskRepository);
        $this->taskStoreUseCase = new TaskStoreUseCase($this->taskRepository);
        $this->taskUpdateUseCase = new TaskUpdateUseCase($this->taskRepository);
        $this->taskDestroyUseCase = new TaskDestroyUseCase($this->taskRepository);
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
            "target_id" => 1,
            "task_title" => "タスクテスト1",
            "period_kind" => "DAY",
            "start_date" => "2021-02-10",
            "end_date" => "2021-02-10",
            "is_done" => 0,
        ];
        $result = $this->taskIndexUseCase->handle(1);
        $this->assertEquals($expected, $result[0]);
    }

    public function test_show(){
        $expected = [
            "id" => 1,
            "user_id" => 1,
            "target_id" => 1,
            "task_title" => "タスクテスト1",
            "period_kind" => "DAY",
            "start_date" => "2021-02-10",
            "end_date" => "2021-02-10",
            "is_done" => 0,
        ];
        $result = $this->taskShowUseCase->handle(1, 1);
        $this->assertEquals($expected, $result);
    }

    public function test_store(){
        $request = [
            "target_id" => 1,
            "task_title" => "showUseCaseテスト",
            "period_kind" => "WEEK",
            "start_date" => "2021-02-10",
            "end_date" => "2021-02-10",
        ];
        $this->taskStoreUseCase->handle($request, 1);
        $this->assertDatabaseHas('tasks', [
            'task_title' => "showUseCaseテスト"
        ]);
    }

    public function test_update(){
        $request = [
            "target_id" => 1,
            "task_title" => "updateUseCaseテスト",
            "period_kind" => "WEEK",
            "start_date" => "2021-02-10",
            "end_date" => "2021-02-10",
            "is_done" => 0
        ];
        $this->taskUpdateUseCase->handle($request, 1, 1);
        $this->assertDatabaseHas('tasks', [
            'task_title' => "updateUseCaseテスト"
        ]);
    }

    public function test_destroy(){
        $this->taskDestroyUseCase->handle(1, 1);
        $this->assertDatabaseMissing('tasks', [
            'id' => 1
        ]);
    }
}
