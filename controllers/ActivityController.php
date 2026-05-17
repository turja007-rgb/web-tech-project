<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';
require_once '../config/helpers.php';

if (!isset($_SESSION['user_id'])) exit;

$project_id = $_GET['project_id'] ?? 0;
$filter_user_id = $_GET['user_id'] ?? '';

$query = "SELECT a.*, u.name FROM activity_logs a JOIN users u ON a.user_id = u.id WHERE a.project_id = ?";
$params = ["i", $project_id];

if ($filter_user_id !== '') {
    $query .= " AND a.user_id = ?";
    $params[0] .= "i";
    $params[] = $filter_user_id;
}

$query .= " ORDER BY a.created_at DESC LIMIT 50";

$stmt = $conn->prepare($query);
$stmt->bind_param(...$params);
$stmt->execute();
$result = $stmt->get_result();

$logs = [];
while ($row = $result->fetch_assoc()) {
    $row['time_ago'] = time_elapsed_string($row['created_at']);
    $row['initials'] = strtoupper(substr($row['name'], 0, 2));
    $logs[] = $row;
}

echo json_encode($logs);
?>