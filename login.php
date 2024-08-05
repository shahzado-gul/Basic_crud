<?php

session_start();
if (isset($_SESSION["user"])) {
    header('Location: index.php');
    exit();
}
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


if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password =$_POST['password'];
    require_once "db.php";
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    if($user){
        if(password_verify($password, $user["password"])){
            session_start();
            $_SESSION["user"] = "yes";
            header("location: index.php");
            die();
        }else{
            echo "password does not match";
        }
    }else{
        echo "email does not match";
    }

}
?>
    <div class="container">
        <form action="" method="post">
            <div class="div"><H1>Login Form</H1></div>
           <div  class="form-group form-control">
            <input type="text" id="Email" name="email" placeholder="email" >
           </div>
           <div  class="form-group form-control">
            <input type="password" id="password" name="password" placeholder="Password" >
           </div>
            <div class="form-control">
            <input type="submit" class="btn btn-primary" value="Login" name="login">
            <a href="./register.php" class="btn btn-primary pr-3 ml-5">Register</a>
            </div>
        </form>
    </div>
</body>
</html>