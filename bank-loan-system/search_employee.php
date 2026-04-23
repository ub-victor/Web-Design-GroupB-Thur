<?php
include "db.php";

header('Content-Type: application/json');

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    
    $stmt = $conn->prepare("SELECT * FROM employees WHERE employee_name LIKE ? LIMIT 1");
    if (!$stmt) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $conn->error
        ]);
        exit;
    }
    
    $searchTerm = "%$search%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
        echo json_encode([
            'status' => 'success',
            'record' => $record
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Employee not found'
        ]);
    }
    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No search parameter provided'
    ]);
}

$conn->close();
?>
