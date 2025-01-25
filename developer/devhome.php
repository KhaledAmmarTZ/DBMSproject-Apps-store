<?php
   session_start();
   if($_SESSION['developer_login_status']!="logged in" and ! isset($_SESSION['developer_id']) )
    header("Location:../login.php");
   //Sign Out code
   if(isset($_GET['sign']) and $_GET['sign']=="out") {
	$_SESSION['developer_login_status']="logged out";
	unset($_SESSION['developer_id']);
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
	<style>
	#menu-button {      
            top: 10px;
            left: 10px;
            cursor: pointer;
            z-index: 999;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 20px;
            height: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
        }

        #menu-button div {
            height: 3px;
            background-color: #000;
            width: 20px;
        }
	#overlay {
            display: none;
            position: fixed;
            top:100px;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998;
            padding: 20px;
        }

        #overlay button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #00CDFE;
			color: #fff;
            border: 1px solid #00CDFE;
            border-radius: 10px;
            cursor: pointer;
        }
	</style>
	
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
                        <div class="logo" onclick="toggleOverlay()">
                            <img src="assets/images/logo.png" alt="" style="width: 158px;">
							<div id="overlay">
							<button onclick="navigateToPage('#')">My App Information</button>
							<button onclick="navigateToPage('proproduct.php')">Promote a Product</button>
							<button onclick="navigateToPage('prodinfo.php')">Product Information</button>
							<button onclick="navigateToPage('traninfo.php')">Transaction Information</button>
							<button onclick="navigateToPage('repinfo.php')">Reports Information</button>
							<button onclick="navigateToPage('RERAinfo.php')">Reviews and Rating</button>
							<button onclick="navigateToPage('devhome.php')">back</button>
							<!-- Add more buttons for other pages as needed -->
							</div>
							</div>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="devhome.php" class="active">Home</a></li>
                            <li><a href="../shopUp.php" class="active">Shop</a></li>
                            <li><a href="#" class="active">User Info</a></li>
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
                        $sid = $_SESSION['developer_id'];
                        $sql = "SELECT developer_id, mail, honenumber FROM developer WHERE developer_id=?";

                        // Using prepared statement to prevent SQL injection
                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($stmt, 's', $sid);
                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);

                        $email = $row['mail'];
                        $mbl = $row['honenumber'];
                        echo "<h3>ID# $sid.</h3>";

                        echo "<p><b>Email:</b> $email</br><b>Mobile No.:</b> $mbl</p>";
                        ?>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="right-image">
						<?php
						include("../connect.php");
                        $sid = $_SESSION['developer_id'];
                        $sql = "SELECT developer_id, mage FROM developer WHERE developer_id=?";

                        // Using prepared statement to prevent SQL injection
                        $stmt = mysqli_prepare($con, $sql);
                        mysqli_stmt_bind_param($stmt, 's', $sid);
                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
						$emage= $row['mage'];
                        $imageFilePath = "../image/" . $row['mage'];
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
                    <a href="#">
                        <div class="item">
                            <div class="image">
                                <img src="assets/images/featured-01.png" alt="" style="max-width: 44px;">
                            </div>
                            <h4>#coming soon</h4>
                        </div>
                    </a>
                </div>
				<div class="col-lg-3 col-md-6">
				  <a href="#">
					<div class="item">
					  <div class="image">
						<img src="assets/images/featured-01.png" alt="" style="max-width: 44px;">
					  </div>
					  <h4>#coming soon</h4>
					</div>
				  </a>
				</div>
				<div class="col-lg-3 col-md-6">
				  <a href="devchangeinfo.php">
					<div class="item">
					  <div class="image">
						<img src="assets/images/featured-03.png" alt="" style="max-width: 44px;">
					  </div>
					  <h4>change profile info </h4>
					</div>
				  </a>
				</div>
				<div class="col-lg-3 col-md-6">
				  <a href="decha.php">
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
		function toggleOverlay() {
            var overlay = document.getElementById('overlay');
            overlay.style.display = (overlay.style.display === 'block') ? 'none' : 'block';
        }
    </script>
</body>

</html>
