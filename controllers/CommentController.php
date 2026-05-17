<?php
session_start();

// API-এর জন্য JSON হেডার সেট করা
header('Content-Type: application/json');

require_once '../config/db.php';
require_once '../config/helpers.php';

// ইউজার লগ-ইন করা আছে কি না তা চেক করা
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized user. Please login.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$author_name = $_SESSION['name'];

// ==========================================
// 1. POST Request: নতুন কমেন্ট সেভ করা
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $body = trim($_POST['body']); // ইনপুটের আগে-পরের স্পেস রিমুভ করা

    // --- সার্ভার-সাইড ভ্যালিডেশন (নতুন অ্যাড করা অংশ) ---
    if (empty($body)) {
        echo json_encode(['error' => 'Comment cannot be empty! Please write something.']);
        exit;
    }
    // ----------------------------------------------------

    // ডাটাবেসে কমেন্ট ইনসার্ট করা
    $stmt = $conn->prepare("INSERT INTO comments (task_id, user_id, body) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $task_id, $user_id, $body);

    if ($stmt->execute()) {
        $comment_id = $conn->insert_id;

        // অ্যাক্টিভিটি লগের জন্য টাস্কের title এবং project_id ফেচ করা
        $task_stmt = $conn->prepare("SELECT title, project_id FROM tasks WHERE id = ?");
        $task_stmt->bind_param("i", $task_id);
        $task_stmt->execute();
        $task_res = $task_stmt->get_result()->fetch_assoc();

        if ($task_res) {
            $action_text = "Commented on task '" . $task_res['title'] . "'";
            log_activity($task_res['project_id'], $user_id, $action_text);
        }

        // নতুন কমেন্ট JSON আকারে ফ্রন্টএন্ডে পাঠানো
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

// ==========================================
// 2. DELETE Request: নিজের কমেন্ট ডিলিট করা
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $comment_id = $_GET['id'];

    // কমেন্টের মালিকানা এবং টাস্কের ডেটা চেক করা
    $check_stmt = $conn->prepare("SELECT c.user_id, c.task_id, t.title, t.project_id FROM comments c JOIN tasks t ON c.task_id = t.id WHERE c.id = ?");
    $check_stmt->bind_param("i", $comment_id);
    $check_stmt->execute();
    $comment = $check_stmt->get_result()->fetch_assoc();

    // যদি কমেন্টটি পাওয়া যায় এবং লগ-ইন করা ইউজারই এই কমেন্টের মালিক হয়
    if ($comment && $comment['user_id'] == $user_id) {
        
        $del_stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
        $del_stmt->bind_param("i", $comment_id);
        
        if ($del_stmt->execute()) {
            // ডিলিট করার লগ তৈরি করা
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