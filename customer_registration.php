<?php
session_start();

include("connect.php");

if (isset($_POST['Register'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dateofbirth = mysqli_real_escape_string($con, $_POST['dateofbirth']);
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check for duplicate emai or phone number
    $duplicateCheckQuery = "SELECT * FROM customer WHERE emai = '$email' OR phonenumbe = '$phonenumber'";
    $duplicateCheckResult = mysqli_query($con, $duplicateCheckQuery);

    if (mysqli_num_rows($duplicateCheckResult) > 0) {
        echo "<script type='text/javascript'> alert('email or Phone Number already exists. Please use a different one.')</script>";
    } else {
        // No duplicates found, proceed with insertion
        $customer_id ="Cus.". uniqid(); // Generate a unique ID for the customer
        $query = "INSERT INTO customer (customer_id, usernam, emai, dateofbirt, phonenumbe, passwor) VALUES ('$customer_id','$username', '$email', '$dateofbirth', '$phonenumber', '$password')";
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
                    <input type="radio" name="role" value="developer" onclick="redirectToRegistrationPage('developer')" >
                    <font color="white">Developer</font>
                </label>
                <label>
                    <input type="radio" name="role" value="customer" onclick="redirectToRegistrationPage('customer')" checked>
                    <font color="white">Customer</font>
                </label>
            </div>
            <div class="form-group">
                <label for="usernam"><font color="white">Username:</font></label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="emai"><font color="white">Email:</font></label>
                <input type="emai" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="dateofbirt"><font color="white">Date of Birth:</font></label>
                <input type="date" id="dateofbirth" name="dateofbirth" required>
            </div>
            <div class="form-group">
                <label for="phonenumbe"><font color="white">Phone Number:</font></label>
                <input type="tel" id="phonenumber" name="phonenumber" minlength="8" maxlength="15" required>
            </div>
            <div class="form-group">
                <label for="password"><font color="white">password:</font></label>
                <div class="lform-group">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="toggle-password" onclick="togglepasswor()">Show</button>
                </div>
            </div>
            <button type="submit" class="login-btn" name="Register">Register</button>
        </form>
        <div class="login-link">
            <p><font color="white">Already have an account?</font> <a href="login.php">Login here</a></p>
        </div>
    </div>

    <script>
        function togglepasswor() {
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
