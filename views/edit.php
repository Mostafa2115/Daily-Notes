<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task - ToDo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card p-4">
            <h2 class="mb-4">Edit Task</h2>

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

            <form action="index.php?action=update" method="POST">
                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Task Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($_POST['name'] ?? $task['name']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="datetime-local" name="due_date" id="due_date" class="form-control" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($_POST['due_date'] ?? $task['due_date']))); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="is_complete" class="form-label">Status</label>
                    <select name="is_complete" id="is_complete" class="form-select">
                        <option value="0" <?php echo($task['is_complete'] == 0) ? 'selected' : ''; ?>>Pending</option>
                        <option value="1" <?php echo($task['is_complete'] == 1) ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Task</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
