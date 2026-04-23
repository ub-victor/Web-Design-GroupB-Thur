<?php
include "db.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $empName = trim($_POST['empName']);
    $empAddress = trim($_POST['empAddress']);
    $monthlySalary = floatval($_POST['monthlySalary']);
    $empPeriod = intval($_POST['empPeriod']);
    $benefitRate = floatval($_POST['benefitRate']);
    $loanAmount = floatval($_POST['loanAmount']);
    $totalAmount = floatval($_POST['totalAmount']);
    $monthlyPayment = floatval($_POST['monthlyPayment']);

    // Validate input
    if (empty($empName) || $monthlySalary <= 0 || $loanAmount <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Invalid input data'
        ]);
        exit;
    }

    // Check if employee already exists
    $checkStmt = $conn->prepare("SELECT id FROM employees WHERE employee_name = ?");
    if (!$checkStmt) {
        echo json_encode([
            'status' => 'error',
            'message' => '❌ Database error: ' . $conn->error
        ]);
        exit;
    }
    
    $checkStmt->bind_param("s", $empName);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing employee
        $updateStmt = $conn->prepare("UPDATE employees SET 
                employee_address = ?,
                monthly_salary = ?,
                employment_period = ?,
                benefit_rate = ?,
                loan_amount = ?,
                total_amount = ?,
                monthly_payment = ?
                WHERE employee_name = ?");
        
        if (!$updateStmt) {
            echo json_encode([
                'status' => 'error',
                'message' => '❌ Database error: ' . $conn->error
            ]);
            exit;
        }
        
        $updateStmt->bind_param("sdidddds", $empAddress, $monthlySalary, $empPeriod, $benefitRate, $loanAmount, $totalAmount, $monthlyPayment, $empName);
        
        if ($updateStmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => '✓ Employee record updated successfully!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => '❌ Error updating record: ' . $updateStmt->error
            ]);
        }
        $updateStmt->close();
    } else {
        // Insert new employee
        $insertStmt = $conn->prepare("INSERT INTO employees 
                (employee_name, employee_address, monthly_salary, employment_period, benefit_rate, loan_amount, total_amount, monthly_payment)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$insertStmt) {
            echo json_encode([
                'status' => 'error',
                'message' => '❌ Database error: ' . $conn->error
            ]);
            exit;
        }
        
        $insertStmt->bind_param("ssdidddd", $empName, $empAddress, $monthlySalary, $empPeriod, $benefitRate, $loanAmount, $totalAmount, $monthlyPayment);
        
        if ($insertStmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => '✓ Employee record saved successfully!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => '❌ Error saving record: ' . $insertStmt->error
            ]);
        }
        $insertStmt->close();
    }
    $checkStmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => '❌ Invalid request method'
    ]);
}

$conn->close();
?>
</html>