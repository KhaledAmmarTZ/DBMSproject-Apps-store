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
   // Check if the recharge form is submitted
    if(isset($_POST['recharge'])) {
		 // Include database connection
        include("../connect.php");
        // Generate recharge ID
        $recharge_id = "recharge." . uniqid();

        // Get customer ID from session
        $customer_id = $_SESSION['customer_id'];

        // Get payment method from form
        $payment_method = $_POST['method'];

        // Get recharge amount from form
        $recharge_amount = $_POST['rechargeamount'];

        // Insert recharge details into recharge table
        $insert_recharge_query = "INSERT INTO recharge (recharge_id, customer_id, method, recharge_amount) 
                                VALUES ('$recharge_id', '$customer_id', '$payment_method', '$recharge_amount')";
        $insert_recharge_result = mysqli_query($con, $insert_recharge_query);

        // Update customer amount in customer table
        $update_customer_query = "UPDATE customer SET amount = amount + '$recharge_amount' WHERE customer_id = '$customer_id'";
        $update_customer_result = mysqli_query($con, $update_customer_query);

        // Check if both queries executed successfully
        if ($insert_recharge_result && $update_customer_result) {
            $message = 'Recharge successful';
        } else {
            $message = 'Recharge failed';
        }
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
                        <a href="chhome.php" class="logo">
                            <img src="assets/images/logo.png" alt="" style="width: 158px;">
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="chhome.php" class="active">profile</a></li>
                            <li><a href="login.php" class="active" onclick="navigateToPage('?sign=out')">log out</a></li>

                           
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
				<h4>Recharge Page</h4>
              <div class="login-containert">
					<div>
						<h4><font color="black">Please provide Necessary Information</font></h4>
						<?php
						// Display error message if login failed
						if (isset($error_message)) {
							echo "<p style='color: red;'>$error_message</p>";
						}
						?>
						<form  action="" method="post">
							<div class="lform-group">
								<label for="payment_method"><font color="black">Payment Method:</font></label>
								<div class="password-container">
									<select id="method" name="method" required>
										<option value="">Select Payment Method</option>
										<?php
										// Include database connection
										include("../connect.php");

										// Query to fetch payment methods from the remethod table
										$query = "SELECT method FROM remethod";
										$result = mysqli_query($con, $query);

										// Check if query executed successfully
										if ($result) {
											// Fetch each payment method and create an option element
											while ($row = mysqli_fetch_assoc($result)) {
												echo '<option value="' . $row['method'] . '">' . $row['method'] . '</option>';
											}
										} else {
											echo '<option value="">Error fetching payment methods</option>';
										}
										?>
									</select>
								</div>
							</div>


							<div class="lform-group">
								<label for="rechargeamount"><font color="black">Recharge Amount:</font></label>
								<div class="password-container">
									<input type="text" id="rechargeamount" name="rechargeamount" required onkeypress="return isDecimal(event)">
								</div>
							</div>

							<button type="submit" name="recharge" class="login-btn">Recharge</button>
						</form>
						
					</div> 
					
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
		function isDecimal(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        var dotExist = evt.target.value.indexOf('.') !== -1;
        var inputValue = evt.target.value;

        // Allow digits, backspace, delete, and decimal point
        if ((charCode >= 48 && charCode <= 57) || charCode == 8 || charCode == 46 || charCode == 127) {
            // Allow only one decimal point
            if (charCode == 46 && dotExist) {
                evt.preventDefault();
                return false;
            }
            // Limit to two decimal places
            var decimalIndex = inputValue.indexOf('.');
            if (decimalIndex !== -1 && inputValue.substring(decimalIndex + 1).length >= 2) {
                evt.preventDefault();
                return false;
            }
            return true;
        }
        evt.preventDefault();
        return false;
		}
		window.onload = function() {
        var message = '<?php echo $message; ?>';
        if (message) {
            alert(message); // You can replace this with any other method to display the message
        }
		};
    </script>
</body>
</html>
