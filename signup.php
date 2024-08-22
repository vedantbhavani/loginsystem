<?php
$showAlert = false;
$showError = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include 'partials/dbconnect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $existSql = "SELECT * FROM `users` WHERE username = '$username'";
    $result = mysqli_query($conn, $existSql);
    $numExistsRow = mysqli_num_rows($result);
    if ($numExistsRow > 0) {
        $showError = "User already exists!";
    } else {
        if ($password == $cpassword) {
            $hash = password_hash($password , PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`, `password`, `dt`) VALUES ('$username', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = "User created successfully";
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: welcome.php");
            }
        } else {
            $showError = "Your password not same please try again!";
        }
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require 'partials/nav.php'; ?>

    <!-- Alert and Errors for this form -->
    <?php
    if ($showAlert) {
        echo '<div class=" alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success : </strong> ' . $showAlert . '.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    if ($showError) {
        echo '<div class=" alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error : </strong> ' . $showError . '.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>


    <!-- Signup Form Start  -->
    <div class="container w-50">
        <h2 class="text-center mt-4">Register Page</h2>
        <form action="/loginsystem/signup.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" maxlength="20" class="bg-body-secondary form-control" name="username" id="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="20" class=" bg-body-secondary form-control" name="password" id="password">
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="bg-body-secondary form-control" name="cpassword" id="cpassword">
                <div id="emailHelp" class="form-text">Make sure your password will be same.</div>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>


    <!-- Signup Form finish  -->
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</html>