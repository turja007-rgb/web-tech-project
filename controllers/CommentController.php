<?php
session_start();
header('Content-Type: application/json');

require_once '../config/db.php';
require_once '../config/helpers.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$method = $_SERVER['REQUEST_METHOD'];


if ($method === 'POST') {
    $task_id = $_POST['task_id'];
    $body = $_POST['body'];

    $stmt = $conn->prepare("SELECT project_id, title FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $task = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO comments (task_id, user_id, body, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $task_id, $user_id, $body);
    $stmt->execute();
    $comment_id = $conn->insert_id;
    $stmt->close();

    
    log_activity($conn, $task['project_id'], $user_id, "Commented on task '{$task['title']}'");

    echo json_encode([
        "id" => $comment_id,
        "author_name" => $_SESSION['name'], 
        "body" => $body,
        "created_at" => "Just now"
    ]);
    exit;
}


if ($method === 'DELETE') {
    $comment_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT c.user_id, t.project_id, t.title FROM comments c JOIN tasks t ON c.task_id = t.id WHERE c.id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $comment = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    
    if ($comment && $comment['user_id'] == $user_id) {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("i", $comment_id);
        $stmt->execute();
        
        log_activity($conn, $comment['project_id'], $user_id, "Deleted a comment on task '{$comment['title']}'");
        echo json_encode(["ok" => true]);
    } else {
        echo json_encode(["error" => "Forbidden"]);
    }
    exit;
}
?>