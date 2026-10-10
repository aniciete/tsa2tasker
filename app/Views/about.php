<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Tasker</title>
    <meta name="description" content="Your personal task management assistant">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?= base_url('favicon.ico') ?>">
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
                <?php if (session()->get('user_id') !== null): ?>
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
            <h1>About Tasker</h1>
            <h2>Tasker is a personal task management app made by Charles Lawrence Aniciete.</h2>
        </div>
    </header>

    <section>
        <p>Built for IT0049 Web System Technologies Technical Summative Assessment (TSA2) with full CRUD operations, secure authentication, form validation, and soft deletion.</p>
    </section>

    <footer>
        <div class="copyrights">
            <p>&copy; <?= date('Y') ?> Tasker. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>