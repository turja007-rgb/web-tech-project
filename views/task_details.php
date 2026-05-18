<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../config/db.php';
require_once '../config/helpers.php';

$task_id = isset($_GET['task_id']) ? (int)$_GET['task_id'] : 0;

if ($task_id <= 0) {
    die("Invalid task ID");
}

// Task details
$taskStmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
$taskStmt->bind_param("i", $task_id);
$taskStmt->execute();
$task = $taskStmt->get_result()->fetch_assoc();

if (!$task) {
    die("Task not found");
}

// Security check
$memberStmt = $conn->prepare(
    "SELECT * FROM project_members WHERE project_id = ? AND user_id = ?"
);
$memberStmt->bind_param("ii", $task['project_id'], $_SESSION['user_id']);
$memberStmt->execute();

if ($memberStmt->get_result()->num_rows === 0) {
    die("Access denied");
}

// Comments
$stmt = $conn->prepare(
    "SELECT c.*, u.name
     FROM comments c
     JOIN users u ON c.user_id = u.id
     WHERE c.task_id = ?
     ORDER BY c.created_at ASC"
);

$stmt->bind_param("i", $task_id);
$stmt->execute();
$comments = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="task-details">

    <div class="task-info-box">
        <h2><?= htmlspecialchars($task['title']) ?></h2>

        <p class="task-description">
            <?= nl2br(htmlspecialchars($task['description'])) ?>
        </p>

        <div class="task-meta">
            <span class="badge priority">
                Priority: <?= htmlspecialchars($task['priority']) ?>
            </span>

            <span class="badge due-date">
                Due: <?= htmlspecialchars($task['due_date']) ?>
            </span>

            <span class="badge status">
                Status: <?= htmlspecialchars($task['status']) ?>
            </span>
        </div>
    </div>

    <h3>Task Comments</h3>

    <div id="comment-thread">
        <?php while($c = $comments->fetch_assoc()): ?>

            <div class="comment" id="comment-<?= $c['id'] ?>">

                <strong>
                    <?= htmlspecialchars($c['name']) ?>
                </strong>

                :

                <?= htmlspecialchars($c['body']) ?>

                <small class="time-text">
                    <?= time_elapsed_string($c['created_at']) ?>
                </small>

                <?php if($c['user_id'] == $_SESSION['user_id']): ?>
                    <a href="#"
                       onclick="deleteComment(<?= $c['id'] ?>); return false;"
                       class="delete-btn">
                       Delete
                    </a>
                <?php endif; ?>

            </div>

        <?php endwhile; ?>
    </div>

    <form id="comment-form">

        <input type="hidden" id="task_id" value="<?= $task_id ?>">

        <div id="error-message"></div>

        <textarea
            id="comment_body"
            maxlength="500"
            placeholder="Write a comment..."
            required>
        </textarea>

        <button type="submit">
            Post Comment
        </button>

    </form>
</div>

<script src="../Js/comments.js"></script>
</body>
</html>