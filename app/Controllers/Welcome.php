<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TaskModel;

class Welcome extends BaseController
{
    protected TaskModel $taskModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }

    /**
     * Display today's active tasks on the public dashboard.
     */
    public function index(): string
    {
        $data = [
            'tasks'      => $this->taskModel->getActiveTodayTasks(),
            'isLoggedIn' => session()->get('user_id') !== null,
        ];

        return view('welcome', $data);
    }
}
