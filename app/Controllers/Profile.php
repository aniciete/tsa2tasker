<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Display profile page for the authenticated user or guest visitor.
     */
    public function index(): string
    {
        $userId = session()->get('user_id');

        if ($userId !== null) {
            $user = $this->userModel->find($userId);
            if ($user) {
                $user['isLoggedIn'] = true;

                return view('profile', $user);
            }
        }

        return view('profile', [
            'id'         => '—',
            'username'   => 'Guest',
            'full_name'  => 'Guest Visitor',
            'email'      => 'guest@example.com',
            'created_at' => '—',
            'isLoggedIn' => false,
        ]);
    }
}
