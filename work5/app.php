<?php
$conn = new mysqli("localhost", "root", "Ushindi123!", "accountDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// DETERMINE ACTION
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// LOGIN ACTION
if ($action === 'login') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $sql = "SELECT * FROM Credentials 
            WHERE username='$username' AND password='$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // SUCCESS → redirect
        header("Location: work5B.html");
        exit();
    } else {
        echo "Invalid username or password!";
    }
}

// SIGNUP ACTION
elseif ($action === 'signup') {
    $firstname = $_POST['firstname'] ?? '';
    $lastname  = $_POST['lastname'] ?? '';
    $address   = $_POST['address'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $username  = $_POST['username'] ?? '';
    $password  = $_POST['password'] ?? '';

    // Insert into DB
    $sql = "INSERT INTO Credentials (first_name, last_name, address, telephone, username, password)
            VALUES ('$firstname', '$lastname', '$address', '$telephone', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// SAVE MARKS ACTION
elseif ($action === 'save_marks') {
    $name = $_POST['n'] ?? '';
    $roll = $_POST['r'] ?? '';
    $dept = $_POST['d'] ?? '';
    $cat1 = $_POST['cat1'] ?? 0;
    $cat2 = $_POST['cat2'] ?? 0;
    $fat  = $_POST['fat'] ?? 0;

    $total = $cat1 + $cat2 + $fat;
    $avg = $total / 3;

    $sql = "INSERT INTO RecordsTB (name, roll, department, cat1, cat2, fat, total, average)
            VALUES ('$name','$roll','$dept','$cat1','$cat2','$fat','$total','$avg')";

    if ($conn->query($sql) === TRUE) {
        echo "Saved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// RETRIEVE MARKS ACTION
elseif ($action === 'retrieve_marks' || isset($_POST['retrieve'])) {
    $result = $conn->query("SELECT * FROM RecordsTB");

    echo "<h2>Student Records</h2>";
    echo "<table border='1'>
            <tr>
                <th>Name</th><th>Roll</th><th>Dept</th>
                <th>CAT1</th><th>CAT2</th><th>FAT</th>
                <th>Total</th><th>Average</th>
            </tr>";

    if ($result) {
        if ($result->num_rows === 0) {
            echo "<tr><td colspan='8' style='text-align:center;'>No student records found.</td></tr>";
        } else {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['roll']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['cat1']}</td>
                        <td>{$row['cat2']}</td>
                        <td>{$row['fat']}</td>
                        <td>{$row['total']}</td>
                        <td>{$row['average']}</td>
                      </tr>";
            }
        }
    } else {
        echo "<tr><td colspan='8' style='text-align:center;color:red;'>Error loading records.</td></tr>";
    }

    echo "</table>";
}

$conn->close();
?>
