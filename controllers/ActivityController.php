<?php
session_start();
header('Content-Type: application/json');

require_once '../config/db.php';
require_once '../config/helpers.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$project_id = isset($_GET['project_id'])
    ? (int)$_GET['project_id']
    : 0;

$filter_user_id = isset($_GET['user_id'])
    ? trim($_GET['user_id'])
    : '';

$query =
    "SELECT a.*, u.name
     FROM activity_logs a
     JOIN users u ON a.user_id = u.id
     WHERE a.project_id = ?";

$params = [$project_id];
$types = "i";

if ($filter_user_id !== '') {
    $query .= " AND a.user_id = ?";
    $types .= "i";
    $params[] = $filter_user_id;
}

$query .= " ORDER BY a.created_at DESC LIMIT 50";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

$logs = [];

while ($row = $result->fetch_assoc()) {

    $parts = explode(' ', $row['name']);

    $initials = '';

    foreach ($parts as $p) {
        $initials .= strtoupper($p[0]);
    }

    $row['initials'] = substr($initials, 0, 2);

    $row['time_ago'] = time_elapsed_string(
        $row['created_at']
    );

    $logs[] = $row;
}


echo json_encode($logs);