<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\TaskModel;
use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Database\Seeds\TaskerSeeder;

/**
 * @internal
 */
final class ModelsTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $seed = TaskerSeeder::class;

    public function testUserModelHasRequiredAllowedFields(): void
    {
        $userModel = new UserModel();
        $fields = $userModel->allowedFields;

        $this->assertContains('username', $fields);
        $this->assertContains('full_name', $fields);
        $this->assertContains('email', $fields);
        $this->assertContains('password', $fields);
        $this->assertContains('created_at', $fields);
    }

    public function testUserModelContainsDemoUserWithHashedPassword(): void
    {
        $userModel = new UserModel();
        $user = $userModel->where('username', 'charles')->first();

        $this->assertNotNull($user);
        $this->assertSame('Charles Lawrence Aniciete', $user['full_name']);
        $this->assertSame('charles@example.com', $user['email']);
        $this->assertNotSame('TaskerDemo!2026', $user['password']);
        $this->assertTrue(password_verify('TaskerDemo!2026', $user['password']));
    }

    public function testTaskModelHasRequiredAllowedFields(): void
    {
        $taskModel = new TaskModel();
        $fields = $taskModel->allowedFields;

        $this->assertContains('title', $fields);
        $this->assertContains('status', $fields);
        $this->assertContains('task_date', $fields);
        $this->assertContains('is_archived', $fields);
        $this->assertContains('created_at', $fields);
    }

    public function testGetActiveTasksExcludesArchivedTasks(): void
    {
        $taskModel = new TaskModel();
        $activeTasks = $taskModel->getActiveTasks();

        // 10 active tasks, 1 archived task seeded
        $this->assertCount(10, $activeTasks);
        foreach ($activeTasks as $task) {
            $this->assertEquals(0, (int) $task['is_archived']);
        }
    }

    public function testGetActiveTodayTasksFiltersByDateAndExcludesArchived(): void
    {
        $taskModel = new TaskModel();
        $todayTasks = $taskModel->getActiveTodayTasks(date('Y-m-d'));

        // 4 active today tasks
        $this->assertCount(4, $todayTasks);
        foreach ($todayTasks as $task) {
            $this->assertEquals(0, (int) $task['is_archived']);
            $this->assertSame(date('Y-m-d'), $task['task_date']);
        }
    }

    public function testArchiveSoftDeletesTaskWithoutDeletingRow(): void
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find(1);
        $this->assertNotNull($task);
        $this->assertEquals(0, (int) $task['is_archived']);

        $result = $taskModel->archive(1);
        $this->assertTrue($result);

        // Row still exists in database
        $updatedTask = $taskModel->find(1);
        $this->assertNotNull($updatedTask);
        $this->assertEquals(1, (int) $updatedTask['is_archived']);

        // Now excluded from active tasks
        $activeTasks = $taskModel->getActiveTasks();
        $this->assertCount(9, $activeTasks);
    }
}
