<!DOCTYPE html>
<html>
<head>
    <title>Bank Loan Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>BANK LOAN MANAGEMENT SYSTEM</h2>

    <form method="POST" action="save.php">
        
        <label>Employee Name:</label>
        <input type="text" name="name" required>

        <label>Monthly Salary:</label>
        <input type="number" name="salary" required>

        <label>Years of Service:</label>
        <input type="number" name="years" required>

        <label>Loan Amount:</label>
        <input type="number" name="loan" required>

        <button type="submit">CALCULATE</button>
    </form>

</div>

</body>
</html>