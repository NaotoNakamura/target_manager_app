<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use JWTAuth;
use Illuminate\Support\Facades\Artisan;

class TargetControllerTest extends TestCase
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
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }

    public function testIndexWithAssignee()
    {
        \App\Models\Target::factory(1)->create();
        $response = $this->json('GET', '/api/targets', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testStoreWithAssignee()
    {
        $response = $this->json('POST', '/api/targets?target_title=hoge', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testShowWithAssignee()
    {
        $this->json('POST', '/api/targets?target_title=hoge', $this->params, $this->headers);
        $response = $this->json('GET', '/api/targets/3', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testUpdateWithAssignee()
    {
        $this->json('POST', '/api/targets?target_title=hoge', $this->params, $this->headers);
        $response = $this->json('PUT', '/api/targets/3?target_title=update', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testDestroyWithAssignee()
    {
        $this->json('POST', '/api/targets?target_title=hoge', $this->params, $this->headers);
        $response = $this->json('DELETE', '/api/targets/3', $this->params, $this->headers);
        $response->assertStatus(200);
    }

    public function testIndexWithUnassignee()
    {
        $response = $this->json('GET', '/api/targets');
        $response->assertStatus(401);
    }

    public function testStoreWithUnassignee()
    {
        $response = $this->json('POST', '/api/targets?target_title=hoge');
        $response->assertStatus(401);
    }

    public function testShowWithUnassignee()
    {
        $response = $this->json('GET', '/api/targets/3');
        $response->assertStatus(401);
    }

    public function testUpdateWithUnassignee()
    {
        $response = $this->json('PUT', '/api/targets/3?target_title=update');
        $response->assertStatus(401);
    }

    public function testDestroyWithUnassignee()
    {
        $response = $this->json('DELETE', '/api/targets/3');
        $response->assertStatus(401);
    }

    public function test存在しないtargetを取得()
    {
        $response = $this->json('GET', '/api/targets/3', $this->params, $this->headers);
        $response->assertStatus(404);
    }

    public function test存在しないtargetを削除()
    {
        $response = $this->json('DELETE', '/api/targets/3', $this->params, $this->headers);
        $response->assertStatus(404);
    }

    public function test他ユーザーのtargetを取得()
    {
        $response = $this->json('GET', '/api/targets/1', $this->params, $this->headers);
        $response->assertStatus(404);
    }

    public function test他ユーザーのtargetを削除()
    {
        $response = $this->json('DELETE', '/api/targets/1', $this->params, $this->headers);
        $response->assertStatus(404);
    }
}
