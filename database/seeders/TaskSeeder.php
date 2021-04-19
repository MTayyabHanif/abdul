<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create()->each(function ($user) {
            $user->tasks()->save(Task::factory()->makeOne());
            $user->tasks()->save(Task::factory()->makeOne());
            $user->tasks()->save(Task::factory()->makeOne());
            $user->tasks()->save(Task::factory()->makeOne());
        });
    }
}
