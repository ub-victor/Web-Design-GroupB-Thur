<?php
$conn = new mysqli("localhost", "root", "Ushindi123!", "bank_loan_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create employees table if not exists
$sql = "CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(100) NOT NULL,
    employee_address VARCHAR(255),
    monthly_salary DECIMAL(10,2) NOT NULL,
    employment_period INT NOT NULL,
    benefit_rate DECIMAL(5,2),
    loan_amount DECIMAL(10,2),
    total_amount DECIMAL(10,2),
    monthly_payment DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_employee (employee_name)
)";

if ($conn->query($sql) === TRUE) {
    // Table created successfully or already exists
} else {
    if ($conn->errno != 1050) { // 1050 = table already exists
        echo "Error creating table: " . $conn->error;
    }
}
?>