<?php
   session_start();
   if($_SESSION['customer_login_status']!="logged in" and ! isset($_SESSION['customer_id']) )
    header("Location:../login.php");
   //Sign Out code
   if(isset($_GET['sign']) and $_GET['sign']=="out") {
	$_SESSION['customer_login_status']="logged out";
	unset($_SESSION['customer_id']);
   header("Location:../login.php");    
   }

?>

<!-- Rest of your HTML code -->
<!-- ... -->


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
	
	
	<script>
        function navigateToPage(page) {
            window.location.href = page;
        }
    </script>
	
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
                            <li><a href="chhome.php" class="active">Home</a></li>
                            <li><a href="shopC.php" class="active">Shop</a></li>
                            <li><a href="cinfo.php" class="active">User Info</a></li>
                            <li><a href="reportapp.php" class="active">Your report </a></li>
                            <li><a herf="login.php" class="active" onclick="navigateToPage('?sign=out')">log out</a></li>
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
    <div class="main-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="caption header-text">
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

                        $email = $row['emai'];
                        $mbl = $row['phonenumbe'];
                        echo "<h3>ID# $sid.</h3>";

                        echo "<p><b>Email:</b> $email</br><b>Mobile No.:</b> $mbl</p>";
                        ?>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="right-image">
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
            </div>
        </div>
    </div>

    <div class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <a href="recharge.php">
                        <div class="item">
                            <div class="image">
                                <img src="assets/images/featured-01.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>Recharge</h4>
                        </div>
                    </a>
                </div>
				<div class="col-lg-3 col-md-6">
				  <a href="ownapp.php">
					<div class="item">
					  <div class="image">
						<img src="assets/images/featured-01.png" alt="" style="max-width: 44px;">
					  </div>
					  <h4>Your Product</h4>
					</div>
				  </a>
				</div>
				<div class="col-lg-3 col-md-6">
				  <a href="chchanginfo.php">
					<div class="item">
					  <div class="image">
						<img src="assets/images/featured-03.png" alt="" style="max-width: 44px;">
					  </div>
					  <h4>change profile info </h4>
					</div>
				  </a>
				</div>
				<div class="col-lg-3 col-md-6">
				  <a href="chchangpass.php">
					<div class="item">
					  <div class="image">
						<img src="assets/images/featured--05.png" alt="" style="max-width: 44px;">
					  </div>
					  <h4>change password</h4>
					</div>
				  </a>
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
	<script>
        function navigateToPage(page) {
            window.location.href = page;
        }
    </script>
</body>

</html>
