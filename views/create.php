<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Task - ToDo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card p-4">
            <h2 class="mb-4">Add New Task</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php
    endforeach; ?>
                    </ul>
                </div>
            <?php
endif; ?>

            <form action="index.php?action=store" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Task Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="datetime-local" name="due_date" id="due_date" class="form-control" value="<?php echo htmlspecialchars($_POST['due_date'] ?? ''); ?>" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Task</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
