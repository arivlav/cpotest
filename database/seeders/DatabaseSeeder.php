<?php

namespace Database\Seeders;

use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        $projects = ProjectModel::factory(2)->create();

        TaskModel::factory(20)
            ->recycle([$users, $projects])
            ->create();

    }
}
