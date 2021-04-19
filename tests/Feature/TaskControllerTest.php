<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testCreateNewTask()
    {
        $user = User::factory()->create();
        $payload = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'deadline' => $this->faker->dateTime(),
        ];

        $response = $this->actingAs($user)->post('/tasks', $payload);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['name' => $payload['name'], 'user_id' => $user->id]);
    }

    public function testUpdateTask()
    {
        $user = User::factory()->create();
        $fakeTask = $user->tasks()->save(Task::factory()->makeOne());
        $payload = [
            'name' => $fakeTask->name,
            'description' => $fakeTask->description,
            'deadline' => $this->faker->dateTime(),
        ];

        $response = $this->actingAs($user)->put('/tasks/'.$fakeTask->id, $payload);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['deadline' => $payload['deadline'], 'user_id' => $user->id]);
    }

    public function testDeleteTask()
    {
        $user = User::factory()->create();
        $fakeTask = $user->tasks()->save(Task::factory()->makeOne());

        $response = $this->actingAs($user)->delete('/tasks/'.$fakeTask->id,);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $fakeTask->id]);
    }
}
