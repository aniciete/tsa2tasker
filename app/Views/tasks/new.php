<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Create New Task | Tasks for Today') ?></title>
    <meta name="description" content="Add a new task">
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
                <li class="menu-item"><a href="<?= site_url('tasks/new') ?>" class="active">+ New Task</a></li>
                <li class="menu-item">
                    <form action="<?= site_url('logout') ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="nav-logout-btn">Logout (<?= esc(session()->get('username')) ?>)</button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="heroe">
            <h1>Create New Task</h1>
            <h2>Schedule a new task in the management system</h2>
        </div>
    </header>

    <section>
        <div class="form-container">
            <?php if (! empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('tasks') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="title">Task Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control"
                        value="<?= esc(old('title')) ?>" placeholder="e.g., Prepare quarterly budget report" required autofocus>
                </div>

                <div class="form-group">
                    <label for="task_date">Scheduled Date <span class="required">*</span></label>
                    <input type="date" id="task_date" name="task_date" class="form-control"
                        value="<?= esc(old('task_date', date('Y-m-d'))) ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Initial Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="pending" <?= old('status', 'pending') === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="completed" <?= old('status') === 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save Task</button>
                    <a href="<?= site_url('tasks') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>

    <footer>
        <div class="copyrights">
            <p>&copy; <?= date('Y') ?> Tasker. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
