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

$sid = $_SESSION['customer_id'];
$sql = "SELECT customer_id, emai, usernam, dateofbirt,imag, phonenumbe FROM customer WHERE customer_id=?";

// Using prepared statement to prevent SQL injection
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, 's', $sid);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
                        
						

    

    

    

    // Check if the query was successful
    if ($result) {
        // Fetch the details of the specific product along with the developer name
        $customerDetails = mysqli_fetch_assoc($result);

        // Now you can use $customerDetails to display information about the specific product
        // For example, echo $customerDetails['usernam'], $customerDetails['description'], etc.
        // The developer's name can be accessed as $customerDetails['developer_name']
    } else {
        // Handle the case where the query was not successful
        echo "Error: " . mysqli_error($con);
    }

    

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
                    <?php
                    // Check if $customerDetails is set
                    if (isset($customerDetails)) {
                        echo '<h3>' . $customerDetails['usernam'] . '</h3>';
                        echo '<span class="breadcrumb"><a href="#">Home</a>  >  <a href="#">Shop</a>  >  ' . $customerDetails['usernam'] . '</span>';
                    } else {
                        echo '<h3>Product Not Found</h3>';
                        echo '<span class="breadcrumb"><a href="#">Home</a>  >  <a href="#">Shop</a>  >  Not Found</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
					<div class="left-image">
						<?php
						include("../connect.php");
                        $sid = $_SESSION['customer_id'];
                        $sql = "SELECT customer_id, emai, phonenumbe, imag FROM customer WHERE customer_id=?";

                        // Using prepared statement to prevent SQL injection
                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($stmt, 's', $sid);
                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
						$emage= $row['imag'];
                        $imageFilePath = "../image/" . $row['imag'];
                        if (file_exists($imageFilePath)) {
                            echo '<img src="' . $imageFilePath . '" alt="Product Image">';
                        } else {
                            echo 'Image file not found.';
                        }
                        ?>
						

					</div>
				</div>

                <div class="col-lg-6 align-self-center">
					<div class="product-details">
						<?php
						echo '<h4 style="display: inline;">' . (isset($customerDetails['usernam']) ? $customerDetails['usernam'] : 'Customer Not Found') . '</h4>';
						?>
					</div>

					<ul>
						<li><span>Customer ID:</span><?php echo isset($customerDetails) ? $customerDetails['customer_id'] : 'Customer Not Found'; ?></li>
						<li><span>Email:</span><?php echo isset($customerDetails) ? $customerDetails['emai'] : 'Customer Not Found'; ?></li>
						<li><span>Username:</span><?php echo isset($customerDetails) ? $customerDetails['usernam'] : 'Customer Not Found'; ?></li>
						<li><span>Date of Birth:</span><?php echo isset($customerDetails) ? $customerDetails['dateofbirt'] : 'Customer Not Found'; ?></li>
						<li><span>Phone Number:</span><?php echo isset($customerDetails) ? $customerDetails['phonenumbe'] : 'Customer Not Found'; ?></li>
					</ul>

					<!-- You can add more details based on your table structure -->

					<form id="qty" action="placeholder_action.php" method="post">
						<!-- Add any additional form elements as needed -->
					</form>
				</div>
				

                <div class="col-lg-12">
                    <div class="sep"></div>
                </div>
            </div>
        </div>
    </div>


    

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
