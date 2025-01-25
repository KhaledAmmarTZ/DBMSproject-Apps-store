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
    <title>Transaction</title>
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

        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #5bc0de;
        }

        p {
            color: #333;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Transaction Information</h1>

			<?php
            // Assuming you have a database connection established ($con)
            include("../connect.php");

            // Check if 'transaction_id' is set in the URL
            if (isset($_GET['transaction_id'])) {
                // Get the transaction ID from the URL
                $transaction_id = $_GET['transaction_id'];

                // Query to fetch transaction details along with related product information
                $query = "SELECT transaction.*, product.app_name, product.price, developer.sername AS developer_name,developer.mail AS developer_email, customer.usernam AS customer_name, customer.emai AS customer_email
                          FROM transaction
                          JOIN product ON transaction.product_id = product.product_id
                          JOIN developer ON product.developer_id = developer.developer_id
                          JOIN customer ON transaction.customer_id = customer.customer_id
                          WHERE transaction.transaction_id = '$transaction_id'";

                $result = mysqli_query($con, $query);

                // Check if the query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    $transactionDetails = mysqli_fetch_assoc($result);

                    // Display transaction and product details
                    echo '<p>Transaction ID: ' . $transactionDetails['transaction_id'] . '</p>';
                    echo '<p>Product Name: ' . $transactionDetails['app_name'] . '</p>';
                    echo '<p>Developer: ' . $transactionDetails['developer_name'] . '</p>';
					echo '<p>Developer Email: ' . $transactionDetails['developer_email'] . '</p>';
                    echo '<p>Customer: ' . $transactionDetails['customer_name'] . '</p>';
                    echo '<p>Customer Email: ' . $transactionDetails['customer_email'] . '</p>';
                    echo '<p>Transaction Date: ' . $transactionDetails['transaction_date'] . '</p>';
                    echo '<p>Transaction Amount: $' . $transactionDetails['transaction_amount'] . '</p>';
                    echo '<p>Product Price: $' . $transactionDetails['price'] . '</p>';
                } else {
                    echo '<p>Error fetching transaction details.</p>';
                }
            } else {
                echo '<p>Transaction ID is not set in the URL.</p>';
            }
        ?>

        <a href="ShopC.php" class="redirect-button">Go to Shop</a>
    </div>
</body>
</html>
