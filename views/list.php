<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List - Native PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">My Tasks</h2>
                <a href="index.php?action=create" class="btn btn-primary">Add New Task</a>
            </div>

            <?php if (isset($_SESSION['flash'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['flash']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php
endif; ?>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Status</th>
                            <th>Task Name</th>
                            <th>Due Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tasks)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">No tasks found. Start by adding one!</td>
                            </tr>
                        <?php
else: ?>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td>
                                        <form action="index.php?action=toggle" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   onchange="this.form.submit()" 
                                                   <?php echo $task['is_complete'] ? 'checked' : ''; ?>>
                                        </form>
                                        <span class="badge badge-status <?php echo $task['is_complete'] ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                            <?php echo $task['is_complete'] ? 'Completed' : 'Pending'; ?>
                                        </span>
                                    </td>
                                    <td class="<?php echo $task['is_complete'] ? 'task-completed' : ''; ?>">
                                        <?php echo htmlspecialchars($task['name']); ?>
                                    </td>
                                    <td>
                                        <?php echo date('M d, Y H:i', strtotime($task['due_date'])); ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="index.php?action=edit&id=<?php echo $task['id']; ?>" class="btn btn-sm btn-outline-info">Edit</a>
                                        <form action="index.php?action=delete" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
    endforeach; ?>
                        <?php
endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
