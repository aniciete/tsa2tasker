<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tasker Profile</title>
    <meta name="description" content="Your personal task management assistant">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>

<body>

    <header>
        <div class="menu">
            <ul>
                <li class="menu-item"><a href="<?= site_url('/') ?>">Welcome</a></li>
                <li class="menu-item"><a href="<?= site_url('about') ?>">About</a></li>
                <li class="menu-item"><a href="<?= site_url('profile') ?>" class="active">Profile</a></li>
                <li class="menu-item"><a href="<?= site_url('tasks') ?>">Tasks</a></li>
                <?php if (! empty($isLoggedIn)): ?>
                    <li class="menu-item"><a href="<?= site_url('tasks/new') ?>">+ New Task</a></li>
                    <li class="menu-item">
                        <form action="<?= site_url('logout') ?>" method="post" style="display:inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="nav-logout-btn">Logout (<?= esc(session()->get('username')) ?>)</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="menu-item"><a href="<?= site_url('login') ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="heroe">
            <h1>Profile</h1>
            <h2><?= ! empty($isLoggedIn) ? 'Hi, ' . esc($full_name) . '!' : 'User Account Overview' ?></h2>
        </div>
    </header>

    <section>
        <div class="profile-card">
            <div class="profile-avatar">
                <?= esc(strtoupper(substr($username, 0, 1))) ?>
            </div>
            <div class="profile-details">
                <h2><?= esc($full_name) ?></h2>
                <p class="profile-handle">@<?= esc($username) ?></p>

                <div class="profile-info-grid">
                    <div class="info-item">
                        <span class="info-label">User ID:</span>
                        <span class="info-value"><?= esc($id) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value"><?= esc($email) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Member Since:</span>
                        <span class="info-value"><?= esc($created_at) ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Account Role:</span>
                        <span class="info-value">
                            <span class="badge badge-<?= ! empty($isLoggedIn) ? 'completed' : 'pending' ?>">
                                <?= ! empty($isLoggedIn) ? 'Authenticated Staff' : 'Guest Visitor' ?>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($isLoggedIn)): ?>
            <p class="auth-notice" style="margin-top: 1.5rem;">
                Looking to manage tasks? <a href="<?= site_url('login') ?>">Log in</a> with your staff credentials.
            </p>
        <?php endif; ?>
    </section>

    <footer>
        <div class="copyrights">
            <p>&copy; <?= date('Y') ?> Tasker. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>