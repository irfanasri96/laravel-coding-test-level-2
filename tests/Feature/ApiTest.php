<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    public function testCreateUser() {
        User::truncate();

        $authUser = User::factory()->create(['role' => 'admin']);
        Passport::actingAs($authUser, ['admin'], 'api');

        $data = [
            'username' => 'Johndoe',
            'password' => 'password',
            'role' => 'team_member'
        ];
        $response = $this->post(route('users.store'), $data);
        $response->assertJsonStructure([
            'success',
            'data',
            'message'
        ]);
    }

    public function testCreateProject() {
        User::truncate();
        Project::truncate();
        $authUser = User::factory()->create(['role' => 'product_owner']);
        Passport::actingAs($authUser, [$authUser->role], 'api');

        $data = [
            'name' => 'MyCar'
        ];
        $response = $this->post(route('projects.store'), $data);
        $response->assertJsonStructure([
            'success',
            'data',
            'message'
        ]);
    }

    public function testUpdateAssignTask() {
        User::truncate();
        Project::truncate();
        Task::truncate();

        $authUser = User::factory()->create(['role' => 'team_member']);
        Passport::actingAs($authUser, [$authUser->role], 'api');

        $project = Project::factory()->create();

        $task = Task::factory()->create([
            'project_id' => $project->id,
            'user_id' => $authUser->id
        ]);

        $data = [
            'status' => 'COMPLETED'
        ];
        $response = $this->patch(route('tasks.update', ['task' => $task->id]), $data);
        $response->assertJsonStructure([
            'success',
            'data',
            'message'
        ]);
    }
}
