<?php
include "db.php";

$name = $_POST['name'];
$salary = $_POST['salary'];
$years = $_POST['years'];
$loan = $_POST['loan'];

// Determine interest rate
if ($years < 3) {
    $rate = 10;
} elseif ($years >= 3 && $years <= 5) {
    $rate = 8;
} else {
    $rate = 5;
}

// Calculate total and monthly
$total = $loan + ($loan * $rate / 100);
$months = 12; // 1 year repayment
$monthly = $total / $months;

// Save to database
$sql = "INSERT INTO loans 
(employee_name, monthly_salary, years_of_service, interest_rate, loan_amount, total_amount, monthly_payment)
VALUES ('$name','$salary','$years','$rate','$loan','$total','$monthly')";

$conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Result</title>
</head>
<body>

<h2>Loan Result</h2>

<p><strong>Interest Rate:</strong> <?php echo $rate; ?>%</p>
<p><strong>Total Amount:</strong> <?php echo $total; ?></p>
<p><strong>Monthly Payment:</strong> <?php echo $monthly; ?></p>

<a href="index.php">Go Back</a>

</body>
</html>