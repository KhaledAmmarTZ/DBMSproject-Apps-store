<?php
session_start();
include("connect.php");

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $sql_admin = "SELECT admin_id, email, password FROM admin WHERE email='$email' AND password='$password'";
    $sql_customer = "SELECT customer_id, emai, passwor, status FROM customer WHERE emai='$email' AND passwor='$password'";
    $sql_developer = "SELECT developer_id, mail, assword, status FROM developer WHERE mail='$email' AND assword='$password'";

    $result_admin = mysqli_query($con, $sql_admin);
    $result_customer = mysqli_query($con, $sql_customer);
    $result_developer = mysqli_query($con, $sql_developer);

    if (mysqli_num_rows($result_admin) == 1) {
        $row = mysqli_fetch_assoc($result_admin);
        $_SESSION['admin_id'] = $row['admin_id'];
        $_SESSION['user_id'] = $email;
        $_SESSION['admin_login_status'] = "logged in";
        header("Location: admin1/adhome.php");
        exit();
    } else if (mysqli_num_rows($result_customer) == 1) {
        $row = mysqli_fetch_assoc($result_customer);
        if ($row['status'] == 1) { // Check if status is 1
            $_SESSION['customer_id'] = $row['customer_id'];
            $_SESSION['user_id'] = $email;
            $_SESSION['customer_login_status'] = "logged in";
            header("Location: customer1/chhome.php");
            exit();
        } else {
            $error_message = "Your account is not active. Please contact support.";
        }
    } else if (mysqli_num_rows($result_developer) == 1) {
        $row = mysqli_fetch_assoc($result_developer);
        if ($row['status'] == 1) { // Check if status is 1
            $_SESSION['developer_id'] = $row['developer_id'];
            $_SESSION['user_id'] = $email;
            $_SESSION['developer_login_status'] = "logged in";
            header("Location: developer/devhome.php");
            exit();
        } else {
            $error_message = "Your account is not active. Please contact support.";
        }
    } else {
        $error_message = "Incorrect email or Password";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="animate-in">
    <video autoplay muted loop id="video-bg">
        <source src="Screenshot (5)_animation.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="login-container">
        <h2><font color="white">LOG IN</font></h2>
        <?php
        // Display error message if login failed
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="email"><font color="white">Email:</font></label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password"><font color="white">Password:</font></label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
        <div class="register-link">
            <p><font color="white">Don't have an account?</font> <a href="register.php"> Register Here</a></p>
        </div>
		<div class="register-link">
            <p><font color="white">Go see store</font> <a href="shop.php"> Click here</a></p>
        </div>
    </div>
    <script>
        window.addEventListener("beforeunload", function () {
            document.body.classList.add("animate-out");
        });
    </script>
</body>
</html>
