<?php
session_start();

if ($_SESSION['customer_login_status'] != "logged in" and !isset($_SESSION['customer_id'])) {
    header("Location:../login.php");
}

// Sign Out code
if (isset($_GET['sign']) and $_GET['sign'] == "out") {
    $_SESSION['customer_login_status'] = "logged out";
    unset($_SESSION['customer_id']);
    header("Location:../login.php");
}

include("../connect.php");


?>

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
                        <a href="shopC.php" class="logo">
                            <img src="assets/images/logo.png" alt="" style="width: 158px;">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="chhome.php">profile</a></li>
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
                    <h4>Your Product</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product section">	
		<?php
		include("../connect.php");
		$sid = $_SESSION['customer_id'];

		// Fetch transactions and corresponding product details
		$transactionSql = "SELECT t.transaction_id, t.transaction_date, p.image AS product_image, p.app_name, p.version
									   FROM transaction t
									   JOIN product p ON t.product_id = p.product_id
									   WHERE t.customer_id=?";
		$stmtTransaction = mysqli_prepare($con, $transactionSql);
		mysqli_stmt_bind_param($stmtTransaction, 's', $sid);
		mysqli_stmt_execute($stmtTransaction);
		$resultTransaction = mysqli_stmt_get_result($stmtTransaction);

		// Display transaction and product information
					while ($rowTransaction = mysqli_fetch_assoc($resultTransaction)) {
						echo'<div class="container">';
						echo'<div class="row">';
						echo'<div class="col-lg-6">';
						echo '<div class="left-image">';
						// Display product image
						$productImage = "../image/" . $rowTransaction['product_image'];
						if (file_exists($productImage)) {
							echo '<img src="' . $productImage . '" style="width: 359px; height: auto;">';
						} else {
							echo 'Product image file not found.';
						}
						echo'</div>';
						echo'</div>';
						echo'<div class="col-lg-6 align-self-center">';
						echo '<div class="transaction-details">';
						

						// Display additional product details
						
						echo '<h4>Transaction ID: ' . $rowTransaction['transaction_id'] . '</h4>';
						echo '<p>Transaction Date: ' . $rowTransaction['transaction_date'] . '</p>';
						echo '<p>App Name: ' . $rowTransaction['app_name'] . '</p>';
						echo '<p>Version: ' . $rowTransaction['version'] . '</p>';
						echo '</div>';
						echo '<div class="col-lg-12">';
						echo '<form id="contact-form" action="" method="post" onsubmit="return false;">';
                        echo '<div class="row">';
                        echo '<div class="col-lg-12">';
                        echo '<fieldset>';
                        echo '<button type="button" id="form-submit" class="orange-button" onclick="redirectToURL(\'https://chat.openai.com\')">PlayS</button>';
                        echo '</fieldset>';
                        echo '</div>';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
						echo '</div>';
						echo '<div class="col-lg-12">';
						echo	'<div class="sep"></div>';
						echo '</div>';
						echo'</div>';
						echo'</div>';
					}
					?>
					
	</div>
   


    

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/counter.js"></script>
    <script src="assets/js/custom.js"></script>
	<script>
					  function redirectToURL(url) {
						window.location.href = url;
					  }
					</script>
</body>
</html>
