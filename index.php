<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!file_exists('db.php')) {
    die("Error: db.php file not found!");
}
require_once 'db.php';

$action = $_GET['action'] ?? 'list';

try {
    switch ($action) {
        case 'list':
            $stmt = $pdo->query("SELECT * FROM task ORDER BY created_at DESC");
            $tasks = $stmt->fetchAll();
            include 'views/list.php';
            break;

        case 'create':
            include 'views/create.php';
            break;

        case 'store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name'] ?? '');
                $due_date = $_POST['due_date'] ?? '';
                $errors = [];

                // Validation
                if (empty($name))
                    $errors[] = "Task name is required.";
                if (empty($due_date))
                    $errors[] = "Due date is required.";

                if (empty($errors)) {
                    $stmt = $pdo->prepare("INSERT INTO task (name, due_date) VALUES (?, ?)");
                    $stmt->execute([$name, $due_date]);

                    $_SESSION['flash'] = "Task created successfully!";
                    header("Location: index.php");
                    exit;
                }
                else {
                    include 'views/create.php';
                }
            }
            break;

        case 'edit':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                header("Location: index.php");
                exit;
            }

            $stmt = $pdo->prepare("SELECT * FROM task WHERE id = ?");
            $stmt->execute([$id]);
            $task = $stmt->fetch();

            if (!$task) {
                header("Location: index.php");
                exit;
            }

            include 'views/edit.php';
            break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;
                $name = trim($_POST['name'] ?? '');
                $due_date = $_POST['due_date'] ?? '';
                $is_complete = $_POST['is_complete'] ?? 0;
                $errors = [];

                if (!$id) {
                    header("Location: index.php");
                    exit;
                }

                if (empty($name))
                    $errors[] = "Task name is required.";
                if (empty($due_date))
                    $errors[] = "Due date is required.";

                if (empty($errors)) {
                    $stmt = $pdo->prepare("UPDATE task SET name = ?, due_date = ?, is_complete = ? WHERE id = ?");
                    $stmt->execute([$name, $due_date, $is_complete, $id]);

                    $_SESSION['flash'] = "Task updated successfully!";
                    header("Location: index.php");
                    exit;
                }
                else {
                    $stmt = $pdo->prepare("SELECT * FROM task WHERE id = ?");
                    $stmt->execute([$id]);
                    $task = $stmt->fetch();
                    include 'views/edit.php';
                }
            }
            break;

        case 'toggle':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;
                if ($id) {
                    $stmt = $pdo->prepare("UPDATE task SET is_complete = NOT is_complete WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['flash'] = "Status updated!";
                }
                header("Location: index.php");
                exit;
            }
            break;

        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'] ?? null;
                if ($id) {
                    $stmt = $pdo->prepare("DELETE FROM task WHERE id = ?");
                    $stmt->execute([$id]);
                    $_SESSION['flash'] = "Task deleted successfully!";
                }
                header("Location: index.php");
                exit;
            }
            break;

        default:
            header("Location: index.php?action=list");
            exit;
    }
}
catch (Exception $e) {
    echo "<div style='color:red; border:2px solid red; padding:20px; font-family:sans-serif;'>";
    echo "<h1>CRITICAL ERROR CAUGHT:</h1>";
    echo "<p><strong>Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>File:</strong> " . htmlspecialchars($e->getFile()) . " (Line: " . $e->getLine() . ")</p>";
    echo "<p><strong>Tip:</strong> If it says 'Table not found', please run <a href='setup.php'>setup.php</a></p>";
    echo "</div>";
}
