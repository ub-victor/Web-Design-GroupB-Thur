<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "DELETE FROM employees";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode([
            'status' => 'success',
            'message' => '✓ All records deleted successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Error deleting records: ' . $conn->error
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Invalid request method'
    ]);
}

$conn->close();
?>
