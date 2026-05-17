<?php
session_start();


$_SESSION['user_id'] = 1;
$_SESSION['name'] = 'Mim';


require_once '../config/db.php';
require_once '../config/helpers.php';

$task_id = 1; 

$stmt = $conn->prepare("SELECT c.*, u.name FROM comments c JOIN users u ON c.user_id = u.id WHERE c.task_id = ? ORDER BY c.created_at ASC");
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
    <h3>Task Comments</h3>
    
    <div id="comment-thread">
        <?php while($c = $comments->fetch_assoc()): ?>
            <div class="comment" id="comment-<?= $c['id'] ?>">
                <strong><?= htmlspecialchars($c['name']) ?></strong>: <?= htmlspecialchars($c['body']) ?> 
                <small class="time-text"><?= time_elapsed_string($c['created_at']) ?></small>
                
                <?php if(isset($_SESSION['user_id']) && $c['user_id'] == $_SESSION['user_id']): ?>
                    <a href="#" onclick="deleteComment(<?= $c['id'] ?>); return false;" class="delete-btn">Delete</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    
   <form id="comment-form">
        <input type="hidden" id="task_id" value="<?= $task_id ?>"> 
        
        <div id="error-message" style="color: red; margin-bottom: 10px; display: none; font-weight: bold;"></div>
        
        <textarea id="comment_body" placeholder="Write a comment..."></textarea>
        <button type="submit">Post Comment</button>
    </form>
</div>

<script src="../js/comments.js"></script>
</body>
</html>