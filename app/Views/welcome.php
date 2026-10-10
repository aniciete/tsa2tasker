<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Tasker!</title>
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
                <?php if ($isLoggedIn): ?>
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
            <h1>Welcome to Tasker!</h1>
            <h2>A personal task management assistant</h2>
        </div>
    </header>

    <section>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('message')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <div class="section-header">
            <h1>Here are your tasks for today.</h1>
            <div>
                <?php if ($isLoggedIn): ?>
                    <a href="<?= site_url('tasks/new') ?>" class="btn btn-primary">+ Create New Task</a>
                <?php endif; ?>
                <a href="<?= site_url('tasks') ?>" class="btn btn-secondary">View All Tasks &rarr;</a>
            </div>
        </div>

        <?php if (! empty($tasks)): ?>
            <div class="task-grid">
                <?php foreach ($tasks as $task): ?>
                    <div class="task-card">
                        <div class="task-card-body">
                            <h2><?= esc($task['title']) ?></h2>
                            <p class="task-meta">
                                <span class="badge badge-<?= $task['status'] === 'completed' ? 'completed' : 'pending' ?>">
                                    <?= esc(ucfirst($task['status'])) ?>
                                </span>
                            </p>
                        </div>
                        <?php if ($isLoggedIn): ?>
                            <div class="task-card-actions">
                                <a href="<?= site_url('tasks/' . $task['id'] . '/edit') ?>" class="btn btn-sm btn-edit">Edit</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No active tasks scheduled for today.</p>
        <?php endif; ?>
    </section>

    <footer>
        <div class="copyrights">
            <p>&copy; <?= date('Y') ?> Tasker. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>