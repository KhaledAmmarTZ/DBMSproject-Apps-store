<?php
session_start();

include("connect.php");

if (isset($_POST['Register'])) {
    $sername = mysqli_real_escape_string($con, $_POST['username']);
    $mail = mysqli_real_escape_string($con, $_POST['email']);
    $ateofbirth = mysqli_real_escape_string($con, $_POST['dateofbirth']);
    $honenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $assword = mysqli_real_escape_string($con, $_POST['password']);

    // Check for duplicate email or phone number
    $duplicateCheckQuery = "SELECT * FROM developer WHERE mail = '$mail' OR honenumber = '$honenumber'";
    $duplicateCheckResult = mysqli_query($con, $duplicateCheckQuery);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        echo "<script type='text/javascript'> alert('Email or Phone Number already exists. Please use a different one.')</script>";
    } else {
        // No duplicates found, proceed with insertion
        $developer_id ="Dev.". uniqid(); // Generate a unique ID for the developer
        $query = "INSERT INTO developer (developer_id, sername, mail, ateofbirth, honenumber, assword) VALUES ('$developer_id','$sername', '$mail', '$ateofbirth', '$honenumber', '$assword')";
        mysqli_query($con, $query);

        echo "<script type='text/javascript'> alert('Successfully Registered')</script>";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="animate-in">
    <video autoplay muted loop id="video-bg">
        <source src="Screenshot (5)_animation.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <link rel="stylesheet" href="styles.css">
    <div class="login-container">
        <h2><font color="white">Developer Register</font></h2>
        <form class="login-form" method="POST">
            <div class="role-options">
                <label>
                    <input type="radio" name="role" value="admin" onclick="redirectToRegistrationPage('admin')">
                    <font color="white">Admin</font>
                </label>
                <label>
                    <input type="radio" name="role" value="developer" onclick="redirectToRegistrationPage('developer')" checked>
                    <font color="white">Developer</font>
                </label>
                <label>
                    <input type="radio" name="role" value="customer" onclick="redirectToRegistrationPage('customer')">
                    <font color="white">Customer</font>
                </label>
            </div>
            <div class="form-group">
                <label for="username"><font color="white">Username:</font></label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email"><font color="white">Email:</font></label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="dateofbirth"><font color="white">Date of Birth:</font></label>
                <input type="date" id="dateofbirth" name="dateofbirth" required>
            </div>
            <div class="form-group">
                <label for="phonenumber"><font color="white">Phone Number:</font></label>
                <input type="tel" id="phonenumber" name="phonenumber" minlength="8" maxlength="15" required>
            </div>
            <div class="form-group">
                <label for="password"><font color="white">Password:</font></label>
                <div class="lform-group">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword()">Show</button>
                </div>
            </div>
            <button type="submit" class="login-btn" name="Register">Register</button>
        </form>
        <div class="login-link">
            <p><font color="white">Already have an account?</font> <a href="login.php">Login here</a></p>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var toggleButton = document.querySelector('.toggle-password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = 'Show';
            }
        }

        function redirectToRegistrationPage(role) {
            var registrationPages = {
                "admin": "admin_registration.php",
                "developer": "developer_registration.php",
                "customer": "customer_registration.php"
            };

            var registrationPage = registrationPages[role];
            if (registrationPage) {
                window.location.href = registrationPage;
            }
        }

        window.addEventListener("beforeunload", function () {
            document.body.classList.add("animate-out");
        });
    </script>
</body>

</html>
