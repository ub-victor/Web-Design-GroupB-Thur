<?php
include "db.php";

header('Content-Type: application/json');

$sql = "SELECT id, employee_name FROM employees ORDER BY employee_name ASC";
$result = $conn->query($sql);

$employees = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

echo json_encode([
    'status' => 'success',
    'employees' => $employees
]);

$conn->close();
?>
