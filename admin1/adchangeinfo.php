<?php
session_start();

if (!isset($_SESSION['admin_login_status']) || $_SESSION['admin_login_status'] !== "logged in" || !isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// Sign Out code
if (isset($_GET['sign']) && $_GET['sign'] === "out") {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}

include("../connect.php");
// Update admin information



    

    
if (isset($_POST['changeinfo'])) {
    $newName = mysqli_real_escape_string($con, $_POST['username']);
    
    $customerId = $_SESSION['admin_id'];

    $updateQuery = "UPDATE admin SET username = ? WHERE admin_id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ss", $newName, $customerId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Information updated successfully";
    } else {
        echo "Error updating information: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

if (isset($_POST['changeinfoo'])) {
    
    $newDateOfBirth = mysqli_real_escape_string($con, $_POST['dateofbirth']);
    
    $customerId = $_SESSION['admin_id'];

    $updateQuery = "UPDATE admin SET  dateofbirth = ? WHERE admin_id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ss", $newDateOfBirth, $customerId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Information updated successfully";
    } else {
        echo "Error updating information: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}
if (isset($_POST['changeinfooo'])) {

    $newPhoneNumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $customerId = $_SESSION['admin_id'];

    $updateQuery = "UPDATE admin SET  phonenumber = ? WHERE admin_id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ss", $newPhoneNumber, $customerId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Information updated successfully";
    } else {
        echo "Error updating information: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

$sid = $_SESSION['admin_id'];
$sql = "SELECT admin_id, email, username, dateofbirth,image, phonenumber FROM admin WHERE admin_id=?";

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
        // For example, echo $customerDetails['username'], $customerDetails['description'], etc.
        // The developer's name can be accessed as $customerDetails['developer_name']
    } else {
        // Handle the case where the query was not successful
        echo "Error: " . mysqli_error($con);
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
		.llogin-btn {
            background-color: #0096ff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            font-size: 16px;
			width: 20%; /* Cover the entire width of the parent container (left partition) */
            height: 100%;	/* Cover the entire height of the parent container (left partition) */
			
            position: center
        }

        .llogin-btn:hover {
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
                            <li><a href="adhome.php" class="active">profile</a></li>
                            
                            
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
				  <h2>Change your Profile Informatioin</h2>
				</div>
				
			</div>
		</div>
    </div>
  
 <div class="features">
    <div class="container">
        <div class="row">
            <div class="item">
                <h4>Change info</h4>
                <div class="login-containert">
                    <div>
                        <h2><font color="white">Change info</font></h2>
                        <?php
                        // Display error message if login failed
                        if (isset($error_message)) {
                            echo "<p style='color: red;'>$error_message</p>";
                        }
                        ?>
                        <form action="" method="post" enctype="multipart/form-data">
						
						
							<div class="lform-group">
								<label for="image"><font color="black">Profile Image:</font></label>
								<div class="password-container">
									<?php
									include("../connect.php");
									$sid = $_SESSION['admin_id'];
									$sql = "SELECT admin_id, email, phonenumber, image FROM admin WHERE admin_id=?";

									// Using prepared statement to prevent SQL injection
									$stmt = mysqli_prepare($con, $sql);
									mysqli_stmt_bind_param($stmt, 's', $sid);
									mysqli_stmt_execute($stmt);

									$result = mysqli_stmt_get_result($stmt);
									$row = mysqli_fetch_assoc($result);
									$emage= $row['image'];
									$imageFilePath = "../image/" . $row['image'];
									if (file_exists($imageFilePath)) {
										echo '<img src="' . $imageFilePath . '" style="width: 200px; height: auto;">';
									} else {
										echo 'Image file not found.';
									}
									?>
									<input type="file" id="image" name="image">
									<button type="submit" name="changeinf" class="llogin-btn" >Change</button>
								</div>
								<?php
								include("../connect.php");
								// Update admin information

								if (isset($_POST['changeinf'])) {
									$customerId = $_SESSION['admin_id'];

									// Image upload handling
									$targetDir = "../image/";
									$targetFile = $targetDir . basename($_FILES["image"]["name"]);
									$uploadOk = 1;
									$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

									

									// Check file size
									if ($_FILES["image"]["size"] > 50000000) {
										echo "Sorry, your file is too large.";
										$uploadOk = 0;
									}

									// Allow only certain file formats
									$allowedExtensions = array("jpg", "jpeg", "png", "gif");
									if (!in_array($imageFileType, $allowedExtensions)) {
										echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
										$uploadOk = 0;
									}

									if ($uploadOk == 0) {
										echo "Sorry, your file was not uploaded.";
									} else {
										// If everything is ok, move the uploaded file
										if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
											// Escape the values to prevent SQL injection
											$newimag = basename($_FILES["image"]["name"]);

											$updateQuery = "UPDATE admin SET image = ? WHERE admin_id = ?";
											$stmt = mysqli_prepare($con, $updateQuery);
											mysqli_stmt_bind_param($stmt, "ss", $newimag, $customerId);

											if (mysqli_stmt_execute($stmt)) {
												echo "Image updated successfully";
											} else {
												echo "Error updating image: " . mysqli_error($con);
											}

											mysqli_stmt_close($stmt);
										} else {
											echo "Sorry, there was an error uploading your file.";
										}
									}
								}
								?>
							</div>
	
	
                            <div class="lform-group">
                                <label for="username"><font color="black">Name:</font></label>
                                <div class="password-container">
								
                                    <input type="text" id="username" name="username" placeholder="<?php echo isset($customerDetails) ? $customerDetails['username'] : 'Enter new name'; ?>">
									<button type="submit" name="changeinfo" class="llogin-btn" >Change</button>
                                </div>
                            </div>

                            <div class="lform-group">
								<label for="dateofbirth"><font color="black">Date of Birth:</font></label>
								<div class="password-container">
									
									<input type="text" id="dateofbirth" name="dateofbirth" placeholder="<?php echo isset($customerDetails) ? $customerDetails['dateofbirth'] : 'Enter new date of birth'; ?>" pattern="\d{4}-\d{2}-\d{2}" title="Please enter a date in the format YYYY-MM-DD">

									<button type="submit" name="changeinfoo" class="llogin-btn">Change</button>
								</div>
							</div>


                            <div class="lform-group">
                                <label for="phonenumber"><font color="black">Phone Number:</font></label>
                                <div class="password-container">
                                    <input type="text" id="phonenumber" name="phonenumber" placeholder="<?php echo isset($customerDetails) ? $customerDetails['phonenumber'] : 'Enter new phonenumber'; ?>">
									<button type="submit" name="changeinfooo" class="llogin-btn" >Change</button>
                                </div>
                            </div>

                            
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
    </script>
</body>
</html>
