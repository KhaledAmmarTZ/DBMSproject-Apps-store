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

// Check if the product_id parameter is present in the URL
if (isset($_GET['product_id'])) {
    // Get the product ID from the URL
    $product_id = $_GET['product_id'];

    // Get the customer ID from the session
    $customer_id = $_SESSION['customer_id'];

    // Check if a transaction already exists for the specific product and customer combination
    $checkTransactionSQL = "SELECT * FROM transaction WHERE product_id = '$product_id' AND customer_id = '$customer_id'";
    $checkTransactionResult = mysqli_query($con, $checkTransactionSQL);

    if (mysqli_num_rows($checkTransactionResult) > 0) {
        // If a transaction already exists, do not proceed with the deduction
        // Redirect to page A with a message indicating that the customer has already bought the product
        header("Location: error.php?message=" . urlencode("You have already purchased this product."));
        exit();
    }

    // Prepare and execute the SQL query to retrieve details of the specific product and customer's amount
    $sql = "SELECT product.*, developer.sername as developer_name, customer.*, customer.amount as customer_amount
            FROM product 
            JOIN developer ON product.developer_id = developer.developer_id 
            LEFT JOIN customer ON customer.customer_id = '$customer_id'
            WHERE product.product_id = '$product_id'";

    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the details of the specific product along with the developer name and customer information
        $productDetails = mysqli_fetch_assoc($result);

        // Check if $productDetails is set
        if (isset($productDetails)) {
            // Check if the customer has enough amount to purchase the product
            if ($productDetails['price'] > $productDetails['customer_amount']) {
                // If customer doesn't have enough amount, display error message and exit
                echo '<div class="error-message">Insufficient funds. You have $' . $productDetails['customer_amount'] . ' in your account. Please recharge your account to purchase this product.</div>';
                exit();
            }

            // Proceed with the purchase if the customer has enough amount
            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Deduct the product price from the customer's amount
                $transaction_id = $product_id . '_' . $customer_id;
                $transaction_date = date('Y-m-d H:i:s');
                $transaction_amount = $productDetails['price'];

                // Deduct the product price from the customer's amount
                $new_amount = $productDetails['customer_amount'] - $transaction_amount;

                // Update customer's amount after purchase
                $updateCustomerAmountSQL = "UPDATE customer SET amount = '$new_amount' WHERE customer_id = '$customer_id'";

                $updateCustomerAmountResult = mysqli_query($con, $updateCustomerAmountSQL);

                if (!$updateCustomerAmountResult) {
                    // Throw an exception if the update query fails
                    throw new Exception(mysqli_error($con));
                }

                // Proceed with the purchase transaction
                $insertTransactionSQL = "INSERT INTO transaction (transaction_id, product_id, customer_id, transaction_date, transaction_amount) 
                                         VALUES ('$transaction_id', '$product_id', '$customer_id', '$transaction_date', '$transaction_amount')";

                $insertResult = mysqli_query($con, $insertTransactionSQL);

                if (!$insertResult) {
                    // Roll back the deduction of customer's amount if the transaction insertion fails
                    $rollbackAmountSQL = "UPDATE customer SET amount = amount + '$transaction_amount' WHERE customer_id = '$customer_id'";
                    mysqli_query($con, $rollbackAmountSQL);

                    // Throw an exception if the query fails
                    throw new Exception(mysqli_error($con));
                }

                // Transaction successful, update total_sold and download_count
                $updateTotalSoldSQL = "UPDATE product SET total_sold = total_sold + " . $productDetails['price'] . " WHERE product_id = '$product_id'";
                $updateDownloadCountSQL = "UPDATE product SET download_count = download_count + 1 WHERE product_id = '$product_id'";

                $updateTotalSoldResult = mysqli_query($con, $updateTotalSoldSQL);
                $updateDownloadCountResult = mysqli_query($con, $updateDownloadCountSQL);
				
				// Update developer's amountre attribute
				$updateDeveloperAmountreSQL = "UPDATE developer SET amountre = amountre + " . $productDetails['price'] . " WHERE developer_id = '" . $productDetails['developer_id'] . "'";
				$updateDeveloperAmountreResult = mysqli_query($con, $updateDeveloperAmountreSQL);

				if (!$updateTotalSoldResult || !$updateDownloadCountResult || !$updateDeveloperAmountreResult) {
					// Roll back the deduction of customer's amount if any update queries fail
					$rollbackAmountSQL = "UPDATE customer SET amount = amount + '$transaction_amount' WHERE customer_id = '$customer_id'";
					mysqli_query($con, $rollbackAmountSQL);

					// Throw an exception if any update queries fail
					throw new Exception(mysqli_error($con));
				}
            
                // Redirect to page A with transaction_id in the URL
                header("Location: transac.php?transaction_id=$transaction_id");
                exit();
            }
            // The rest of your existing code remains unchanged
        } else {
            echo '<h3>Product Not Found</h3>';
            echo '<span class="breadcrumb"><a href="#">Home</a>  >  <a href="#">Shop</a>  >  Not Found</span>';
        }
    } else {
        // Handle the case where the query was not successful
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Handle the case where product_id parameter is not present in the URL
    echo "Invalid request. Please go back to the shop page.";
}
?>




<!-- The rest of your HTML code remains unchanged -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Lugx Gaming - Product Detail</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <style>
        .product-details {
            display: flex;
            align-items: center;
        }

        .name-and-rating {
            display: flex;
            flex-direction: column;
            margin-left: 15px; /* Adjust the margin as needed for spacing */
        }

        .rating {
            font-size: 14px;
            margin-top: 5px;
        }

        .star-rating {
            color: Blue; /* Adjust the color to your preference */
        }
		.error-message {
		color: red;
		font-weight: bold;
		margin-top: 10px;
	}
    </style>
</head>

<body>

<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <a href="index.html" class="logo">
                        <img src="assets/images/logo.png" alt="" style="width: 158px;">
                    </a>
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="shopC.php">Home</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                        <li>
                            <?php
                            $sid = $_SESSION['customer_id'];
                            $sql = "SELECT usernam FROM customer WHERE customer_id=?";

                            // Using prepared statement to prevent SQL injection
                            $stmt = mysqli_prepare($con, $sql);
                            mysqli_stmt_bind_param($stmt, 's', $sid);
                            mysqli_stmt_execute($stmt);

                            $resulttt = mysqli_stmt_get_result($stmt);
                            $row = mysqli_fetch_assoc($resulttt);

                            $name = $row['usernam'];

                            echo "<h3>$name.</h3>";
                            ?>
                            <?php echo "ID: {$_SESSION['customer_id']}";?>
                        </li>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- ***** Header Area End ***** -->

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                // Check if $productDetails is set
                if (isset($productDetails)) {
                    echo '<h3>' . $productDetails['app_name'] . '</h3>';
                    echo '<span class="breadcrumb"><a href="#">Home</a>  >  <a href="#">Shop</a>  >  ' . $productDetails['app_name'] . '</span>';
                } else {
                    echo '<h3>Product Not Found</h3>';
                    echo '<span class="breadcrumb"><a href="#">Home</a>  >  <a href="#">Shop</a>  >  Not Found</span>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="contact-page section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="left-text">
                    <div class="section-heading">
                        <?php
                        echo '<h4 style="display: inline;">' . (isset($productDetails['app_name']) ? $productDetails['app_name'] : 'Product Not Found') . '</h4>';

                        if (isset($productDetails['rating']) && $productDetails['rating'] >= 0 && $productDetails['rating'] <= 5) {
                            echo '<div class="rating star-rating" style="display: inline; margin-left: 20px;">. ';
                            for ($i = 0; $i < $productDetails['rating']; $i++) {
                                echo '<i class="fas fa-star"></i>';
                            }
                            for ($i = $productDetails['rating']; $i < 5; $i++) {
                                echo '<i class="far fa-star"></i>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                    
                    <ul>
						<li><span>About:</span><?php echo isset($productDetails) ? $productDetails['description'] : 'Product Not Found'; ?></li>
                        <li><span>Developer Name:</span><?php echo isset($productDetails) ? ' ' . $productDetails['developer_name'] : ' Product Not Found'; ?></li>
                        <li><span>Game ID:</span><?php echo isset($productDetails) ? ' ' . $productDetails['product_id'] : ' Product Not Found'; ?></li>
						<li><span>Downloads:</span><?php echo isset($productDetails) ? $productDetails['download_count'] : 'Product Not Found'; ?></li>
                        <li><span>Genre:</span><?php echo isset($productDetails) ? ' ' . $productDetails['categoryname'] : ' Product Not Found'; ?></li>
                        <li><span class="price">Price:<?php echo isset($productDetails) ? '$' . $productDetails['price'] : 'Product Not Found'; ?></span></li>
                    </ul>
                    <ul>
                        <li><span>Customer Name:</span><?php echo isset($productDetails) ? ' ' . $productDetails['usernam'] : ' Product Not Found'; ?></li>
                        <li><span>Customer E-mail:</span><?php echo isset($productDetails) ? ' ' . $productDetails['emai'] : ' Product Not Found'; ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="right-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="map">
                                <?php
                                $imageFilePath = "../image/" . $productDetails['image'];

                                if (file_exists($imageFilePath)) {
                                    echo '<img src="' . $imageFilePath . '" alt="Product Image">';
                                } else {
                                    echo 'Image file not found.';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-12">
							<form id="contact-form" action="" method="post" onsubmit="return false;">

                            
                                <div class="row">
                                    <div class="col-lg-12">
                                        <fieldset>
                                            <button type="submit" id="form-submit" class="orange-button" onclick="showConfirmation()">Download</button>
                                        </fieldset>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showConfirmation() {
        var confirmDownload = confirm("Are you sure you want to download this app?");
        if (confirmDownload) {
            // If the user confirms, submit the form
            document.getElementById("contact-form").submit();
        } else {
            // If the user cancels, do nothing or provide feedback
        }
    }
</script>

<footer>
    <div class="container">
        <div class="col-lg-12">
            <p>Copyright © 2048 LUGX Gaming Company. All rights reserved. &nbsp;&nbsp; <a rel="nofollow" href="https://templatemo.com" target="_blank">Design: TemplateMo</a></p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>

</body>

</html>
