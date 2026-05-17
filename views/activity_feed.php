<?php
session_start();


$_SESSION['user_id'] = 1;
$_SESSION['name'] = 'Mim';


require_once '../config/db.php';

$project_id = 4; 

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Activity Feed</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="activity-page">
    <h3>Project Activity</h3>
    <input type="hidden" id="project_id" value="<?= $project_id ?>"> 
    
    <select id="member-filter" style="margin-bottom: 20px; padding: 10px; width: 100%; border-radius: 8px; border: 1px solid #ccc;">
        <option value="">All Members</option>
        <?php while($m = $members->fetch_assoc()): ?>
            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
        <?php endwhile; ?>
    </select>

    <div id="activity-list">
        </div>
</div>

<script src="../js/activity.js"></script>
</body>
</html>