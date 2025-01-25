<?php
   session_start();
   if($_SESSION['admin_login_status']!="logged in" and ! isset($_SESSION['admin_id']) )
    header("Location:../login.php");
   //Sign Out code
   if(isset($_GET['sign']) and $_GET['sign']=="out") {
	$_SESSION['admin_login_status']="logged out";
	unset($_SESSION['admin_id']);
   header("Location:../login.php");    
   }
?>

<!-- Rest of your HTML code -->



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
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.login-containert {
            background-color: #fff;
            padding: 40px;
            
            background-image: url('Screenshot (2).png');
            background-size: cover;
            background-position: center;
            width: 95%; /* Cover the entire width of the parent container (left partition) */
            height: 90%; /* Cover the entire height of the parent container (left partition) */
            position: center; /* Absolute position within the left partition */
            top: 0;
            left: 0;
           
            align-items: center;
            justify-content: center;
            transition: transform 0.5s ease-in-out;
            z-index: 1; /* Ensure the login container is above other content in the left partition */
        }

        .login-containert h2 {
            text-align: center;
		}
		

        .login-btn {
            background-color: #0096ff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            font-size: 16px;
			width: 70%; /* Cover the entire width of the parent container (left partition) */
            height: 100%;	/* Cover the entire height of the parent container (left partition) */
			
            position: center
        }

        .login-btn:hover {
            background-color: #0096ff;
        }
		.lform-group {
            margin-bottom: 10px;
            position: relative;
        }
        .lform-group label {
            display: block;
            margin-bottom: 5px;
        }
        .lform-group input {
            width: 82%;
            padding: 6px;
            border: 3px solid #ccc;
            border-radius: 10px;
        }
		input {
            width: calc(100% - 22px);
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 8px;
            display: inline-block;
        }
        .toggle-password {
            background-color: #eee;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
        }
		.password-container {
        display: flex;
        align-items: center;
		}

		.password-container input {
			flex: 1;
			padding: 10px;
			border: 3px solid #ccc;
			border-radius: 10px;
		}

		.password-container button {
			margin-left: 10px;
			padding: 8px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			background-color: #eee;
		}
		.animate-in {
			-webkit-animation: fadeIn .5s ease-in;
			animation: fadeIn .5s ease-in;
		}

		.animate-out {
			-webkit-transition: opacity .5s;
			transition: opacity .5s;
			opacity: 0;
		}
	</style>
		
	<script>
        function navigateToPage(page) {
            window.location.href = page;
        }
		function togglePassword(fieldId) {
        var passwordInput = document.getElementById(fieldId);
        var toggleButton = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.textContent = 'Hide';
        } else {
            passwordInput.type = 'password';
            toggleButton.textContent = 'Show';
        }
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
                        <a href="adhome.php" class="logo">
                            <img src="assets/images/logo.png" alt="" style="width: 158px;">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="adhome.php" class="active">Profile</a></li>
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
				  
				</div>
				
			</div>
		</div>
    </div>
  
 <div class="features">
    <div class="container">
      <div class="row">
            <div class="item">
				<h4>Change Password</h4>
              <div class="login-containert">
					<div>
						<h2><font color="white">Change Password</font></h2>
						<?php
						// Display error message if login failed
						if (isset($error_message)) {
							echo "<p style='color: red;'>$error_message</p>";
						}
						?>
						<form  action="" method="post">
							<div class="lform-group">
								<label for="oldpassword"><font color="black">Old Password:</font></label>
								<div class="password-container">
									<input type="password" id="oldpassword" name="oldpassword" required>
									<button type="button" class="toggle-password" onclick="togglePassword('oldpassword')">Show</button>
								</div>
							</div>

							<div class="lform-group">
								<label for="newpassword"><font color="black">New Password:</font></label>
								<div class="password-container">
									<input type="password" id="newpassword" name="newpassword" required>
									<button type="button" class="toggle-password" onclick="togglePassword('newpassword')">Show</button>
								</div>
							</div>

							<div class="lform-group">
								<label for="confirmpassword"><font color="black">Confirm Password:</font></label>
								<div class="password-container">
									<input type="password" id="confirmpassword" name="confirmpassword" required>
									<button type="button" class="toggle-password" onclick="togglePassword('confirmpassword')">Show</button>
								</div>
							</div>

							<button type="submit" name="changepassword" class="login-btn">Change Password</button>
						</form>
						
					</div> 
					 <?php
					if (isset($_POST['changepassword'])) {
						include("../connect.php");
						$id = $_SESSION['admin_id'];
						$opass = $_POST['oldpassword'];
						$npass = $_POST['newpassword'];
						$cpass = $_POST['confirmpassword'];

						if ($npass == $cpass) {
							$sql = "SELECT password FROM admin WHERE password='$opass' AND admin_id='$id'";
							$result = mysqli_query($con, $sql);

							if (mysqli_num_rows($result) > 0) {
								$sql1 = "UPDATE admin SET password='$npass' WHERE admin_id='$id'";
								if (mysqli_query($con, $sql1)) {
									echo "Password Changed Successfully!";
								} else {
									echo "Error updating password: " . mysqli_error($con);
								}
							} else {
								echo "Old password does not match";
							}
						} else {
							echo "New password does not match with Confirm password";
						}
					}
					?>
				</div>            
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
