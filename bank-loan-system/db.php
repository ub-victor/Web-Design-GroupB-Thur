<?php
$conn = new mysqli("localhost", "root", "Ushindi123!", "bank_loan_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>