<?php
session_start();
header('Content-Type: application/json');

require_once '../config/db.php';
require_once '../config/helpers.php';
require_once '../models/Comment.php'; 

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized user. Please login.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$author_name = $_SESSION['name'];


$commentModel = new Comment($conn);




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $body = trim($_POST['body']); 

    if (empty($body)) {
        echo json_encode(['error' => 'Comment cannot be empty! Please write something.']);
        exit;
    }

    
    $comment_id = $commentModel->addComment($task_id, $user_id, $body);

    if ($comment_id) {
        
        $task_res = $commentModel->getTaskDetails($task_id);
        if ($task_res) {
            $action_text = "Commented on task '" . $task_res['title'] . "'";
            log_activity($task_res['project_id'], $user_id, $action_text);
        }

        echo json_encode([
            'id' => $comment_id,
            'author_name' => $author_name,
            'body' => $body,
            'created_at' => 'Just now'
        ]);
    } else {
        echo json_encode(['error' => 'Database error: Failed to add comment.']);
    }
    exit;
}




if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $comment_id = $_GET['id'];

    
    $comment = $commentModel->getCommentDetails($comment_id);

    if ($comment && $comment['user_id'] == $user_id) {
        
        
        if ($commentModel->deleteComment($comment_id)) {
            $action_text = "Deleted a comment on task '" . $comment['title'] . "'";
            log_activity($comment['project_id'], $user_id, $action_text);
            echo json_encode(['ok' => true]);
        } else {
            echo json_encode(['error' => 'Failed to delete comment from database.']);
        }
    } else {
        echo json_encode(['error' => 'Unauthorized action or comment not found.']);
    }
    exit;
}
?>