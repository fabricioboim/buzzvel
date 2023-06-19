<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testGetAllTasks()
    {
        $this->authenticate();

        $number = 3;
        Task::factory()->count($number)->create();
        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount($number);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'title',
                'description',
                'attachment',
                'completed',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function testCreateTask()
    {
        $this->authenticate();
        $task = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'completed' => false,
        ];

        $response = $this->post('/api/tasks', $task);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'task' => [
                'id',
                'title',
                'description',
                'attachment',
                'completed',
                'completed_at',
                'user_id',
                'updated_at',
                'created_at',
            ],
        ]);
    }

    public function testGetTaskById()
    {
        $this->authenticate();
        $task = Task::factory()->create();

        $response = $this->get('/api/tasks/' . $task->id);

        $response->assertStatus(200);
        $response->assertJson($task->toArray());
    }

    public function testUpdateTask()
    {
        $this->authenticate();
        $task = Task::factory()->create();

        $updatedTask = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'completed' => true,
        ];

        $response = $this->put('/api/tasks/' . $task->id, $updatedTask);

        $response->assertStatus(200);
        $response->assertJson($updatedTask);
    }

    public function testDeleteTask()
    {
        $this->authenticate();
        $task = Task::factory()->create();

        $response = $this->delete('/api/tasks/' . $task->id);

        $response->assertStatus(204);
        $this->assertNull(Task::find($task->id));
    }

    public function testAllEndpoints()
    {
        $this->testGetAllTasks();
        $this->testCreateTask();
        $this->testGetTaskById();
        $this->testUpdateTask();
        $this->testDeleteTask();
    }
}
