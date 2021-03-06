<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use packages\Domain\Task;
use packages\Infrastructure\TaskRepository;
use Illuminate\Support\Facades\Artisan;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private $taskRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
        $this->seed('TargetsTableSeeder');
        $this->seed('TasksTableSeeder');
        $this->taskRepository = new TaskRepository();
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }

    public function test_タスク一覧が取得できること()
    {
        $result = $this->taskRepository->getAll(1);
        $expected = new Task(
            1,
            1,
            1,
            'タスクテスト1',
            'DAY',
            '2021-02-10',
            '2021-02-10',
            false
        );
        $this->assertEquals($expected, $result[0]);
    }

    public function test_1つのタスクが取得できること() {
        $result = $this->taskRepository->findById(1, 1);
        $expected = new Task(
            1,
            1,
            1,
            'タスクテスト1',
            'DAY',
            '2021-02-10',
            '2021-02-10',
            false
        );
        $this->assertEquals($expected, $result);
    }

    public function test_タスクが作成できること(){
        $task = new Task(
            2,
            1,
            1,
            'タスクテスト2',
            'DAY',
            '2021-02-13',
            '2021-02-13',
            false
        );
        $this->taskRepository->store($task);
        $this->assertDatabaseHas('tasks', [
            'task_title' => "タスクテスト2"
        ]);
    }

    public function test_タスクが更新できること(){
        $task = new Task(
            1,
            1,
            1,
            'タスク更新テスト',
            'DAY',
            '2021-02-13',
            '2021-02-13',
            false
        );
        $this->taskRepository->update($task);
        $this->assertDatabaseHas('tasks', [
            'task_title' => "タスク更新テスト"
        ]);
    }

    public function test_タスクが削除できること(){
        $task = new Task(
            1,
            1,
            1,
            'タスクテスト1',
            'DAY',
            '2021-02-13',
            '2021-02-13',
            false
        );
        $this->taskRepository->destroy($task);
        $this->assertDatabaseMissing('tasks', [
            'id' => 1
        ]);
    }
}
