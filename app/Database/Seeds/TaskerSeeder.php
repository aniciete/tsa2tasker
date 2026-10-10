<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TaskerSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('tasks')->truncate();
        $this->db->table('users')->truncate();

        $demoPassword = 'TaskerDemo!2026';
        $users = [
            [
                'id'         => 1,
                'username'   => 'charles',
                'full_name'  => 'Charles Lawrence Aniciete',
                'email'      => 'charles@example.com',
                'password'   => password_hash($demoPassword, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $inTwoDays = date('Y-m-d', strtotime('+2 days'));

        $tasks = [
            [
                'id'          => 1,
                'title'       => 'Buy groceries (milk, eggs, and bread)',
                'status'      => 'pending',
                'task_date'   => $today,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 2,
                'title'       => 'Morning 30-minute jog in the park',
                'status'      => 'completed',
                'task_date'   => $today,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 3,
                'title'       => 'Water the indoor plants',
                'status'      => 'completed',
                'task_date'   => $today,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 4,
                'title'       => 'Prepare dinner and wash the dishes',
                'status'      => 'pending',
                'task_date'   => $today,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 5,
                'title'       => 'Do laundry and fold clothes',
                'status'      => 'completed',
                'task_date'   => $yesterday,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 6,
                'title'       => 'Take out the trash and recycling bins',
                'status'      => 'completed',
                'task_date'   => $yesterday,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 7,
                'title'       => 'Clean the kitchen counters and vacuum living room',
                'status'      => 'completed',
                'task_date'   => $yesterday,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 8,
                'title'       => 'Pay monthly electric and water bills',
                'status'      => 'pending',
                'task_date'   => $tomorrow,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 9,
                'title'       => 'Schedule dentist checkup appointment',
                'status'      => 'pending',
                'task_date'   => $tomorrow,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 10,
                'title'       => 'Wash the car and check tire pressure',
                'status'      => 'pending',
                'task_date'   => $inTwoDays,
                'is_archived' => 0,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($users);
        $this->db->table('tasks')->insertBatch($tasks);
    }
}
