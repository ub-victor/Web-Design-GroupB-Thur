<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <pre>
<h2>STUDENT LOGIN FORM</h2>
<form action="login.php" method="post">
USER-NAME: <input type="text" name="usename"> <br>
PASSWORD : <input type="password" name="password"> <br>
<input type="submit" name="login" value="Login">  <input type="submit" name="exit" value="Exit">
</form>
    </pre>
    
</body>
</html>

<?php
if(isset($_POST['login'])){
    $username = $_POST['usename'];
    $password = $_POST['password']; 

    // Connect to database
    $conn = mysqli_connect("localhost", "root", "Ushindi123!", "FinalExam2026");
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to check credentials
    $query = "SELECT * FROM Logger2026 WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        // Successful login, redirect to interface.php
        header("Location: interface.php");
        exit();
    } else {
        echo "<p>Invalid username or password.</p>";
    }

    mysqli_close($conn);
}

if(isset($_POST['exit'])){
    // Handle exit, maybe just a message or redirect
    echo "<p>Exiting...</p>";
}
?>