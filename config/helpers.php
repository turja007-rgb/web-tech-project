<?php
function log_activity($conn, $project_id, $user_id, $action_text) {
    $stmt = $conn->prepare("INSERT INTO activity_logs (project_id, user_id, action_text, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $project_id, $user_id, $action_text);
    $stmt->execute();
    $stmt->close();
}

function time_elapsed_string($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    
    if ($diff->d > 0) return $diff->d . " days ago";
    if ($diff->h > 0) return $diff->h . " hours ago";
    if ($diff->i > 0) return $diff->i . " minutes ago";
    return "Just now";
}
?>