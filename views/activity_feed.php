<?php
session_start();
require_once '../config/db.php';

$project_id = 1; 


$stmt = $conn->prepare("
    SELECT u.id, u.name 
    FROM project_members pm 
    JOIN users u ON pm.user_id = u.id 
    WHERE pm.project_id = ?
");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$members = $stmt->get_result();
?>

<div class="activity-page">
    <h2>Project Activity</h2>
    <input type="hidden" id="project_id" value="<?= $project_id ?>"> 
    
    <select id="member-filter">
        <option value="">All Members</option>
        <?php while($m = $members->fetch_assoc()): ?>
            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
        <?php endwhile; ?>
    </select>

    <div id="activity-list">
        </div>
</div>

<script src="../assets/js/activity.js"></script>