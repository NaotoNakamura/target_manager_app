<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use JWTAuth;
use Illuminate\Support\Facades\Artisan;

class TaskControllerTest extends TestCase
{
    use DatabaseTransactions;
    private $headers;
    private $params;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
        $this->seed('TargetsTableSeeder');
        $userName = 'nunulk';
        $user = User::factory(User::class)->create(['name' => $userName]);
        $this->headers = ['Authorization' => 'Bearer ' . JWTAuth::fromUser($user)];
        $this->params = ['assignee' => $userName];
        $this->json('POST', '/api/targets?target_title=hoge', $this->params, $this->headers);
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }

    public function testIndexWithAssignee()
    {
        $response = $this->json('GET', '/api/tasks', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testStoreWithAssignee()
    {
        $response = $this->json('POST', '/api/tasks?task_title=hoge&target_id=3&period_kind=DAY&start_date=2021/02/06&end_date=2021/02/20', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testShowWithAssignee()
    {
        $this->json('POST', '/api/tasks?task_title=hoge&target_id=3&period_kind=DAY&start_date=2021/02/06&end_date=2021/02/20', $this->params, $this->headers);
        $response = $this->json('GET', '/api/tasks/1', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testUpdateWithAssignee()
    {
        $this->json('POST', '/api/tasks?task_title=hoge&target_id=3&period_kind=DAY&start_date=2021/02/06&end_date=2021/02/20', $this->params, $this->headers);
        $response = $this->json('PUT', '/api/tasks/1?task_title=fuga&period_kind=WEEK&start_date=2021/03/01&end_date=2021/03/15&is_done=1', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testDestroyWithAssignee()
    {
        $this->json('POST', '/api/tasks?task_title=hoge&target_id=3&period_kind=DAY&start_date=2021/02/06&end_date=2021/02/20', $this->params, $this->headers);
        $response = $this->json('DELETE', '/api/tasks/1', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testIndexWithUnassignee()
    {
        $response = $this->json('GET', '/api/tasks');
        $response->assertStatus(401);
    }

    public function testStoreWithUnassignee()
    {
        $response = $this->json('POST', '/api/tasks?task_title=hoge');
        $response->assertStatus(401);
    }

    public function testShowWithUnassignee()
    {
        $response = $this->json('GET', '/api/tasks/3');
        $response->assertStatus(401);
    }

    public function testUpdateWithUnassignee()
    {
        $response = $this->json('PUT', '/api/tasks/1?task_title=fuga&period_kind=WEEK&start_date=2021/03/01&end_date=2021/03/15&is_done=1');
        $response->assertStatus(401);
    }

    public function testDestroyWithUnassignee()
    {
        $response = $this->json('DELETE', '/api/tasks/1');
        $response->assertStatus(401);
    }

    public function test存在しないtaskを取得()
    {
        $response = $this->json('GET', '/api/tasks/3', $this->params, $this->headers);
        $response->assertStatus(404);
    }

    public function test存在しないtaskを削除()
    {
        $response = $this->json('DELETE', '/api/tasks/3', $this->params, $this->headers);
        $response->assertStatus(404);
    }

    public function test他ユーザーのtaskを取得()
    {
        $response = $this->json('GET', '/api/tasks/1', $this->params, $this->headers);
        $response->assertStatus(404);
    }

    public function test他ユーザーのtaskを削除()
    {
        $response = $this->json('DELETE', '/api/tasks/1', $this->params, $this->headers);
        $response->assertStatus(404);
    }
}
