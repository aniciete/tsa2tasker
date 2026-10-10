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
                <li class="menu-item"><a href="<?= site_url('profile') ?>">Profile</a></li>
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
            <h2>Hi, <?= esc($username) ?>!</h2>
            <h3>ID: <?= esc($id) ?></h3>
            <h3>Full name: <?= esc($full_name) ?></h3>
            <h3>Email: <?= esc($email) ?></h3>
            <h3>Created at: <?= esc($created_at) ?></h3>
        </div>
    </header>

    <section>
        <?php if (! empty($isLoggedIn)): ?>
            <p>You are currently logged in as <strong><?= esc($username) ?></strong>.</p>
        <?php else: ?>
            <p>Demo user profile (Guest view). <a href="<?= site_url('login') ?>">Log in</a> to manage tasks.</p>
        <?php endif; ?>
    </section>

    <footer>
        <div class="copyrights">
            <p>&copy; <?= date('Y') ?> Tasker. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>