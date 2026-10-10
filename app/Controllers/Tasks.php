<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Tasks extends BaseController
{
    protected TaskModel $taskModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }

    /**
     * Display the public list of active tasks.
     */
    public function index(): string
    {
        $data = [
            'tasks'      => $this->taskModel->getActiveTasks(),
            'isLoggedIn' => session()->get('user_id') !== null,
        ];

        return view('tasks', $data);
    }

    /**
     * Render the form to create a new task (authenticated).
     */
    public function new(): string
    {
        return view('tasks/new', [
            'title'  => 'Create New Task | Tasks for Today',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    /**
     * Validate and persist a newly created task (authenticated).
     */
    public function create(): RedirectResponse
    {
        $rules = [
            'title' => [
                'label' => 'Task Title',
                'rules' => 'required|min_length[3]|max_length[150]',
            ],
            'task_date' => [
                'label' => 'Task Date',
                'rules' => 'required|valid_date',
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'permit_empty|in_list[pending,completed]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->taskModel->insert([
            'title'       => trim((string) $this->request->getPost('title')),
            'status'      => $this->request->getPost('status') ?: 'pending',
            'task_date'   => $this->request->getPost('task_date'),
            'is_archived' => 0,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('tasks'))->with('message', 'Task created successfully.');
    }

    /**
     * Render the form to edit an existing task (authenticated).
     */
    public function edit(int $id): string
    {
        $task = $this->taskModel->find($id);

        if (! $task || (int) ($task['is_archived'] ?? 0) === 1) {
            throw PageNotFoundException::forPageNotFound('Task not found.');
        }

        return view('tasks/edit', [
            'task'   => $task,
            'title'  => 'Edit Task | Tasks for Today',
            'errors' => session()->getFlashdata('errors') ?? [],
        ]);
    }

    /**
     * Validate and update an existing task (authenticated).
     */
    public function update(int $id): RedirectResponse
    {
        $task = $this->taskModel->find($id);

        if (! $task || (int) ($task['is_archived'] ?? 0) === 1) {
            throw PageNotFoundException::forPageNotFound('Task not found.');
        }

        $rules = [
            'title' => [
                'label' => 'Task Title',
                'rules' => 'required|min_length[3]|max_length[150]',
            ],
            'task_date' => [
                'label' => 'Task Date',
                'rules' => 'required|valid_date',
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'permit_empty|in_list[pending,completed]',
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->taskModel->update($id, [
            'title'     => trim((string) $this->request->getPost('title')),
            'status'    => $this->request->getPost('status') ?: 'pending',
            'task_date' => $this->request->getPost('task_date'),
        ]);

        return redirect()->to(site_url('tasks'))->with('message', 'Task updated successfully.');
    }

    /**
     * Soft-delete (archive) an existing task (authenticated).
     */
    public function delete(int $id): RedirectResponse
    {
        $task = $this->taskModel->find($id);

        if (! $task) {
            throw PageNotFoundException::forPageNotFound('Task not found.');
        }

        $this->taskModel->archive($id);

        return redirect()->to(site_url('tasks'))->with('message', 'Task archived successfully.');
    }
}
