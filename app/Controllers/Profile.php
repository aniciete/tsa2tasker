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
     * Display profile page for the logged-in user or demo fallback.
     */
    public function index(): string
    {
        $userId = session()->get('user_id');
        $user   = null;

        if ($userId !== null) {
            $user = $this->userModel->find($userId);
        }

        if (! $user) {
            $user = $this->userModel->first() ?? [
                'id'         => '',
                'username'   => 'Guest',
                'full_name'  => '',
                'email'      => '',
                'created_at' => '',
            ];
        }

        $user['isLoggedIn'] = $userId !== null;

        return view('profile', $user);
    }
}
