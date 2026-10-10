<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'status', 'task_date', 'is_archived', 'created_at'];
    protected $useTimestamps    = false;

    /**
     * Retrieve all active (non-archived) tasks ordered chronologically.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getActiveTasks(): array
    {
        return $this->where('is_archived', 0)
            ->orderBy('task_date', 'ASC')
            ->findAll();
    }

    /**
     * Retrieve active (non-archived) tasks scheduled for today.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getActiveTodayTasks(?string $date = null): array
    {
        $targetDate = $date ?? date('Y-m-d');

        return $this->where('is_archived', 0)
            ->where('task_date', $targetDate)
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * Soft-delete a task by setting is_archived to 1.
     */
    public function archive(int $id): bool
    {
        return (bool) $this->update($id, ['is_archived' => 1]);
    }
}
