<?php
include "db.php";

header('Content-Type: application/json');

$sql = "SELECT * FROM employees ORDER BY created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $conn->error
    ]);
    exit;
}

if ($result->num_rows > 0) {
    $records = [];
    while($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
    echo json_encode([
        'status' => 'success',
        'records' => $records
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No records found'
    ]);
}

$conn->close();
?>
