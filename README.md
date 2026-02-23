# Native PHP ToDo App

A simple CRUD ToDo application built with native PHP, PDO, and Bootstrap.

## Features
- Create tasks
- List all tasks
- Edit tasks
- Delete tasks (POST only)
- Toggle task completion
- Flash success messages
- Server-side validation
- XSS protection using `htmlspecialchars`
- SQL Injection protection using `PDO` prepared statements

## Requirements
- PHP 7.4+
- MySQL/MariaDB

## Installation
1. Clone this repository to your web server directory (e.g., `htdocs` in XAMPP).
2. Create a database named `todos`.
3. Run the following SQL to create the `task` table:

```sql
CREATE TABLE task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    is_complete TINYINT(1) NOT NULL DEFAULT 0,
    due_date DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

4. Configure your database credentials in `db.php`.
5. Open the application in your browser (e.g., `http://localhost/To-Do-list native/`).

## Project Structure
- `index.php`: The main controller and router.
- `db.php`: Database connection setup.
- `assets/css/style.css`: Custom application styles.
- `views/`: Directory containing PHP view files.
- `README.md`: This documentation.
