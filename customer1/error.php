<?php
session_start();

include("../connect.php");

if ($_SESSION['customer_login_status'] != "logged in" and !isset($_SESSION['customer_id'])) {
    header("Location:../login.php");
}

// Sign Out code
if (isset($_GET['sign']) and $_GET['sign'] == "out") {
    $_SESSION['customer_login_status'] = "logged out";
    unset($_SESSION['customer_id']);
    header("Location:../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #d9534f;
        }

        p {
            color: #333;
            margin-top: 10px;
        }

        .redirect-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #5bc0de;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Error Occurred</h1>
        <p>An error occurred during the transaction. Please try again later.</p>

        <?php
            // Check if an error message is present in the URL
            if (isset($_GET['error'])) {
                $errorMessage = urldecode($_GET['error']);
                echo '<p>Error Message: ' . $errorMessage . '</p>';
				
            }
			
        ?>
		<p>You Already Have This APP.</p>

        <a href="ShopC.php" class="redirect-button">Go to Shop</a>
    </div>
</body>
</html>
