<?php
// session_start();
// if (!isset($_SESSION["user"])) {
//     header('Location: login.php');
//     exit();
// }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="./css/css/bootstrap.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>

<?php

if (isset($_POST['submit'])) {
    $name = $_POST['FullName'];
    $email = $_POST['Email'];
    $Password = $_POST['Password'];
    $repeat_password = $_POST['password_repeat']; 

    $errors = array();

    if (empty($name) || empty($email) || empty($Password) || empty($repeat_password)) { 
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is invalid");
    }
    if (strlen($Password) < 8) {
        array_push($errors, "Password must be at least 8 characters");
    }
    if ($Password !== $repeat_password) { 
        array_push($errors, "Passwords do not match");
    }

    if (count($errors) > 0) {
        foreach ($errors as $this_error) {
            echo "<div class='alert alert-danger'>$this_error</div>";
        }
    } else {

        require_once("db.php");

        // Check if email already exists (simple version)
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='alert alert-danger'>Email already exists</div>";
        } else {
            // Hash the password
            $PasswordHash = password_hash($Password, PASSWORD_DEFAULT);

            // Insert user into database
            $sql = "INSERT INTO users (full_name, email, password) VALUES ('$name', '$email', '$PasswordHash')";
            if (mysqli_query($conn, $sql)) {
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Something went wrong</div>";
            }
        }
    }
}
?>

<div class="container">
    <form action="./register.php" method="post">
        <div class="div"><h1>Registration Form</h1></div>
        <div class="form-group form-control">
            <input type="text" id="FullName" name="FullName" placeholder="Name">
        </div>
        <div class="form-group form-control">
            <input type="text" id="Email" name="Email" placeholder="Email">
        </div>
        <div class="form-group form-control">
            <input type="password" id="Password" name="Password" placeholder="Password"> 
        </div>
        <div class="form-group form-control">
            <input type="password" id="RepeatPassword" name="password_repeat" placeholder="Repeat Password">
        </div>
        <div class="form-group">
            <input class="btn btn-primary pr-3 ml-5" type="submit" value="Register" name="submit">
            <a href="./login.php" class="btn btn-primary pr-3 ml-5">Login</a>
        </div>
    </form>
</div>

</body>
</html>
