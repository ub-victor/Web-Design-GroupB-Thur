<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$server = 'localhost';
$user = 'root';
$password = 'Ushindi123!';
$database = 'DBGroupA2026';
$tableName = 'Fees2026';

$fields = [
    'student_names' => '',
    'student_id' => '',
    'academic_year' => '',
    'no_of_course' => '',
    'total_credit' => '',
    'amount_per_credit' => '',
    'registration_fees' => '',
    'final_project' => '',
    'graduation_fees' => '',
    'total_fees' => '',
];

$message = '';
$tableRecords = [];
$printScript = false;

function sanitizeInput($value) {
    return trim($value);
}

function fetchRecords($conn, $limit = null) {
    $query = 'SELECT student_id, no_of_course, total_credit, final_project, student_names, academic_year, amount_per_credit, registration_fees, graduation_fees, total_fees FROM Fees2026';
    if ($limit !== null) {
        $query .= ' LIMIT ' . intval($limit);
    }
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

try {
    $conn = mysqli_connect($server, $user, $password);
    mysqli_set_charset($conn, 'utf8mb4');
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `{$database}`");
    mysqli_select_db($conn, $database);
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `{$tableName}` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_names VARCHAR(150) NOT NULL,
        student_id VARCHAR(50) NOT NULL,
        academic_year VARCHAR(50) NOT NULL,
        no_of_course INT DEFAULT 0,
        total_credit INT DEFAULT 0,
        amount_per_credit DECIMAL(10,2) DEFAULT 0,
        registration_fees DECIMAL(10,2) DEFAULT 0,
        final_project DECIMAL(10,2) DEFAULT 0,
        graduation_fees DECIMAL(10,2) DEFAULT 0,
        total_fees DECIMAL(12,2) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($fields as $name => $value) {
            if (isset($_POST[$name])) {
                $fields[$name] = sanitizeInput($_POST[$name]);
            }
        }

        if (isset($_POST['calculate_total_fees'])) {
            $fields['total_fees'] = number_format(
                (floatval($fields['total_credit']) * floatval($fields['amount_per_credit']))
                + floatval($fields['registration_fees'])
                + floatval($fields['final_project'])
                + floatval($fields['graduation_fees']),
                2,
                '.',
                ''
            );
            $message = 'Total fees calculated.';
        }

        if (isset($_POST['save'])) {
            if (empty($fields['student_names']) || empty($fields['student_id'])) {
                $message = 'Student name and ID are required to save data.';
            } else {
                if (empty($fields['total_fees'])) {
                    $fields['total_fees'] = number_format(
                        (floatval($fields['total_credit']) * floatval($fields['amount_per_credit']))
                        + floatval($fields['registration_fees'])
                        + floatval($fields['final_project'])
                        + floatval($fields['graduation_fees']),
                        2,
                        '.',
                        ''
                    );
                }
                $insert = sprintf(
                    "INSERT INTO `%s` (student_names, student_id, academic_year, no_of_course, total_credit, amount_per_credit, registration_fees, final_project, graduation_fees, total_fees) VALUES ('%s','%s','%s',%d,%d,%.2f,%.2f,%.2f,%.2f,%.2f)",
                    $tableName,
                    mysqli_real_escape_string($conn, $fields['student_names']),
                    mysqli_real_escape_string($conn, $fields['student_id']),
                    mysqli_real_escape_string($conn, $fields['academic_year']),
                    intval($fields['no_of_course']),
                    intval($fields['total_credit']),
                    floatval($fields['amount_per_credit']),
                    floatval($fields['registration_fees']),
                    floatval($fields['final_project']),
                    floatval($fields['graduation_fees']),
                    floatval($fields['total_fees'])
                );
                mysqli_query($conn, $insert);
                $message = 'Data saved successfully.';
            }
        }

        if (isset($_POST['retrieve'])) {
            $tableRecords = fetchRecords($conn);
            $message = 'All records retrieved from the database.';
        }

        if (isset($_POST['display'])) {
            $tableRecords = fetchRecords($conn, 4);
            $message = 'Four records displayed from the database.';
        }

        if (isset($_POST['cancel'])) {
            foreach ($fields as $name => $value) {
                $fields[$name] = '';
            }
            $message = 'Form cleared.';
        }

        if (isset($_POST['delete'])) {
            foreach ($fields as $name => $value) {
                $fields[$name] = '';
            }
            $message = 'Text fields cleared.';
        }

        if (isset($_POST['print'])) {
            $printScript = true;
            $message = 'Printing the interface.';
        }
    }
} catch (Exception $e) {
    $message = 'Database error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>interface</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4f4f4;
        }

        .page {
            width: 95%;
            max-width: 1200px;
            border: 3px solid #000;
            background: #fff;
            box-shadow: 0 0 0 10px #f4f4f4;
            overflow: hidden;
            position: relative;
        }

        .page::before,
        .page::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 40px;
            background: #f4f4f4;
            top: 0;
        }

        .page::before {
            left: -10px;
        }

        .page::after {
            right: -10px;
        }

        .page-inner {
            padding: 20px 30px;
        }

        .navbar {
            background: black;
            padding: 12px 0;
            text-align: center;
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
        }

        .navbar li {
            color: #fff;
            padding: 8px 14px;
            background: rgba(0, 0, 0, 0.45);
            border-radius: 4px;
            font-weight: 600;
        }

        .banner {
            margin: 24px 0;
            padding: 18px 20px;
            border: 1px solid rgba(0, 0, 0, 0.8);
            background: rgba(0, 0, 0, 0.12);
        }

        .banner h2 {
            margin: 0;
            color: #000;
            font-size: 1.1rem;
            text-align: center;
            line-height: 1.4;
        }

        .message {
            margin: 0 0 16px;
            padding: 12px 16px;
            border: 1px solid #000;
            background: #fff;
            color: #000;
        }

        .content {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 24px;
            align-items: start;
        }

        .left,
        .right {
            background: #fff;
            padding: 18px;
            min-height: 400px;
        }

        .left {
            display: grid;
            gap: 12px;
        }

        .field {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .field label {
            flex: 0 0 45%;
            color: #000;
            font-weight: 600;
        }

        .field input[type="text"] {
            flex: 1;
            padding: 8px 10px;
            border: 1px solid #000;
            border-radius: 4px;
            background: #fafafa;
        }

        .right table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .right th,
        .right td {
            border: 1px solid #000;
            padding: 12px;
            text-align: left;
        }

        .table-actions,
        .calc-row,
        .footer {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .table-actions {
            margin-bottom: 12px;
        }

        .calc-row {
            justify-content: space-between;
        }

        .calc-row input[type="text"] {
            flex: 1;
            max-width: 240px;
            padding: 8px 10px;
            border: 1px solid #000;
            border-radius: 4px;
            background: #fafafa;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .button-group input[type="submit"],
        .table-actions input[type="submit"],
        .calc-row input[type="submit"] {
            padding: 10px 16px;
            border: 1px solid #000;
            background: #000;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
            font-weight: 700;
        }

        .divider {
            width: 100%;
            height: 1px;
            background: #000;
            opacity: 0.3;
            margin: 12px 0;
        }

        .records-section {
            margin-top: 22px;
            background: #fff;
            padding: 18px;
            border: 1px solid #000;
        }

        .records-section h3 {
            margin: 0 0 14px;
            font-size: 1rem;
            color: #000;
        }

        .records-table {
            width: 100%;
            border-collapse: collapse;
        }

        .records-table th,
        .records-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .footer {
            margin-top: 28px;
            padding: 16px 18px;
            width: 100%;
            justify-content: center;
            background: rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(0,0,0,0.8);
        }

        .footer h3 {
            margin: 0;
            color: #000;
            font-weight: 600;
            font-size: 0.95rem;
            text-align: center;
        }

        @media (max-width: 860px) {
            .content {
                grid-template-columns: 1fr;
            }

            .calc-row {
                flex-direction: column;
                align-items: stretch;
            }

            .calc-row input[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="page-inner">
            <form action="interface.php" method="post">
                <div class="navbar">
                    <ul>
                        <li>Home</li>
                        <li>About</li>
                        <li>Admission</li>
                        <li>Academics</li>
                        <li>Media Center</li>
                        <li>Research</li>
                        <li>AUCA Alumni</li>
                    </ul>
                </div>

                <div class="banner">
                    <h2>ADVENTIST UNIVERSITY OF CENTRAL AFRICA STUDENT FEES MANAGEMENT SYSTEM</h2>
                </div>

                <?php if ($message): ?>
                    <div class="message"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <div class="content">
                    <div class="left">
                        <div class="field">
                            <label>STUDENT NAMES:</label>
                            <input type="text" name="student_names" value="<?= htmlspecialchars($fields['student_names']) ?>">
                        </div>
                        <div class="field">
                            <label>STUDENT-ID:</label>
                            <input type="text" name="student_id" value="<?= htmlspecialchars($fields['student_id']) ?>">
                        </div>
                        <div class="field">
                            <label>ACADEMIC YEAR:</label>
                            <input type="text" name="academic_year" value="<?= htmlspecialchars($fields['academic_year']) ?>">
                        </div>
                        <div class="field">
                            <label>NO OF COURSE:</label>
                            <input type="text" name="no_of_course" value="<?= htmlspecialchars($fields['no_of_course']) ?>">
                        </div>
                        <div class="field">
                            <label>TOTAL CREDIT:</label>
                            <input type="text" name="total_credit" value="<?= htmlspecialchars($fields['total_credit']) ?>">
                        </div>
                        <div class="field">
                            <label>AMOUNT PER CREDIT:</label>
                            <input type="text" name="amount_per_credit" value="<?= htmlspecialchars($fields['amount_per_credit']) ?>">
                        </div>
                        <div class="field">
                            <label>REGISTRATION FEES:</label>
                            <input type="text" name="registration_fees" value="<?= htmlspecialchars($fields['registration_fees']) ?>">
                        </div>
                        <div class="field">
                            <label>FINAL PROJECT:</label>
                            <input type="text" name="final_project" value="<?= htmlspecialchars($fields['final_project']) ?>">
                        </div>
                        <div class="field">
                            <label>GRADUATION FEES:</label>
                            <input type="text" name="graduation_fees" value="<?= htmlspecialchars($fields['graduation_fees']) ?>">
                        </div>
                    </div>

                    <div class="right">
                        <table>
                            <thead>
                                <tr>
                                    <th>STUDENT ID</th>
                                    <th>NO OF COURSE</th>
                                    <th>TOTAL CREDIT</th>
                                    <th>FINAL PROJECT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tableRecords)): ?>
                                    <?php foreach ($tableRecords as $record): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($record['student_id']) ?></td>
                                            <td><?= htmlspecialchars($record['no_of_course']) ?></td>
                                            <td><?= htmlspecialchars($record['total_credit']) ?></td>
                                            <td><?= htmlspecialchars($record['final_project']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php for ($i = 0; $i < 4; $i++): ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <div class="table-actions">
                            <input type="submit" name="update" value="UPDATE FEES">
                            <input type="submit" name="delete" value="DELETE">
                            <input type="submit" name="display" value="DISPLAY">
                        </div>

                        <div class="divider"></div>

                        <div class="calc-row">
                            <input type="submit" name="calculate_total_fees" value="CALCULATE TOTAL FEES">
                            <input type="text" readonly name="total_fees" value="<?= htmlspecialchars($fields['total_fees']) ?>" placeholder="OUTPUT">
                        </div>

                        <div class="divider"></div>

                        <div class="button-group">
                            <input type="submit" name="save" value="SAVE DATA">
                            <input type="submit" name="retrieve" value="RETRIEVE DATA">
                            <input type="submit" name="cancel" value="CANCEL">
                            <input type="submit" name="print" value="PRINT">
                            <input type="submit" name="exit" value="EXIT">
                        </div>
                    </div>
                </div>

                <?php if (!empty($tableRecords)): ?>
                    <div class="records-section">
                        <h3>Retrieved Records</h3>
                        <table class="records-table">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Student ID</th>
                                    <th>Academic Year</th>
                                    <th>No Of Course</th>
                                    <th>Total Credit</th>
                                    <th>Amount Per Credit</th>
                                    <th>Registration Fees</th>
                                    <th>Final Project</th>
                                    <th>Graduation Fees</th>
                                    <th>Total Fees</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tableRecords as $record): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($record['student_names']) ?></td>
                                        <td><?= htmlspecialchars($record['student_id']) ?></td>
                                        <td><?= htmlspecialchars($record['academic_year']) ?></td>
                                        <td><?= htmlspecialchars($record['no_of_course']) ?></td>
                                        <td><?= htmlspecialchars($record['total_credit']) ?></td>
                                        <td><?= htmlspecialchars($record['amount_per_credit']) ?></td>
                                        <td><?= htmlspecialchars($record['registration_fees']) ?></td>
                                        <td><?= htmlspecialchars($record['final_project']) ?></td>
                                        <td><?= htmlspecialchars($record['graduation_fees']) ?></td>
                                        <td><?= htmlspecialchars($record['total_fees']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="footer">
                    <h3>copyright &copy; 2024 Adventist University of Central Africa All Reserved</h3>
                </div>
            </form>
        </div>
    </div>

    <?php if ($printScript): ?>
        <script>window.print();</script>
    <?php endif; ?>
</body>
</html>
