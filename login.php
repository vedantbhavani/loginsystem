<?php
$showAlert = false;
$showError = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include 'partials/dbconnect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "Select * from users where username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $showAlert = "You are logged in successfully";
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: welcome.php");
            }
            else{
                $showError = "password is incorrect !";
            }
        }
    } else {
        $showError = " User not found!";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login User</title>
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
        <strong>Error : </strong>' . $showError . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <!-- Signup Form Start  -->
    <div class="container w-50">
        <h2 class="text-center mt-4">Login Page</h2>
        <form action="/loginsystem/login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" maxlength="20" class="bg-body-secondary form-control" name="username" id="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="20" class=" bg-body-secondary form-control" name="password" id="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>


    <!-- Signup Form finish  -->
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</html>