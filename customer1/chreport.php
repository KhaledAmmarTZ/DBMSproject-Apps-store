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

    // Prepare and execute the SQL query to retrieve details of the specific product
    $sql = "SELECT product.*, developer.sername as developer_name, customer.*
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
            // Check if the form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get the form data
                $bug = isset($_POST['bug']) ? 1 : 0;
                $crash = isset($_POST['crash']) ? 1 : 0;
                $performance = isset($_POST['performance']) ? 1 : 0;
                $feature = isset($_POST['feature']) ? 1 : 0;
                $additionalComments = mysqli_real_escape_string($con, $_POST['additionalComments']);

                // Insert data into the report table
                $report_id ="RE.".  uniqid(); // You may want to generate a unique ID for the report
                $insertReportSQL = "INSERT INTO report (report_id, customer_id, product_id, bug, crash, performance, feature, additionalComments) 
                                    VALUES ('$report_id', '$customer_id', '$product_id', '$bug', '$crash', '$performance', '$feature', '$additionalComments')";

                $insertReportResult = mysqli_query($con, $insertReportSQL);

                if (!$insertReportResult) {
					// Handle the case where the insert query fails
					$errorMessage = "Error: " . mysqli_error($con);
				} else {
					// Set success message
					$successMessage = "Your report has been submitted successfully.";
				}
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


<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Lugx Gaming Template - Contact Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
	<style>
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold; /* Added font-weight for better visibility */
        }

        
    </style>
<!--

TemplateMo 589 lugx gaming

https://templatemo.com/tm-589-lugx-gaming

-->
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
      
        
        <div class="left-text">
            <ul>

                        <li><span>Game ID:</span><?php echo isset($productDetails) ? ' ' . $productDetails['product_id'] : ' Product Not Found'; ?></li>
						
                    </ul>
                    <ul>
                        <li><span>Customer Name:</span><?php echo isset($productDetails) ? ' ' . $productDetails['usernam'] : ' Product Not Found'; ?></li>
                        <li><span>Customer E-mail:</span><?php echo isset($productDetails) ? ' ' . $productDetails['emai'] : ' Product Not Found'; ?></li>
                    </ul>
        </div>
       
              
              <div class="col-lg-12">
                <?php
					// Display success message if set
					if (isset($successMessage)) {
						echo '<p style="color: green;">' . $successMessage . '</p>';
					}

					// Display error message if set
					if (isset($errorMessage)) {
						echo '<p style="color: red;">' . $errorMessage . '</p>';
					}
					?>
				<form id="appReportForm" action="" method="post" onsubmit="return validateForm()">
					<div class="row">
						<label>
							<input type="checkbox" name="bug" value="Bug"> Bug
						</label>
						<label>
							<input type="checkbox" name="crash" value="Crash"> Crash
						</label>
						<label>
							<input type="checkbox" name="performance" value="Performance Issue"> Performance Issue
						</label>
						<label>
							<input type="checkbox" name="feature" value="Feature Request"> Feature Request
						</label>
						<label for="additionalComments">Additional Comments:</label>
						<textarea id="additionalComments" name="additionalComments" rows="4" cols="50"></textarea>

						<button type="submit">Submit Report</button>
					</div>
				</form>
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
    function submitForm() {
        var form = document.getElementById("appReportForm");
        var formData = new FormData(form);

        // You can now handle the form data as needed, for example, send it to a server using AJAX.
        // Example using fetch API:
        fetch('your_server_endpoint', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Handle the response from the server
            console.log(response);
        })
        .catch(error => {
            // Handle errors
            console.error(error);
        });
    }
	function validateForm() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        var checked = false;

        checkboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                checked = true;
            }
        });

        // Check if at least one checkbox is checked OR additionalComments has some content
        if (!checked && document.getElementById('additionalComments').value.trim() === "") {
            alert("Please select at least one option or provide additional comments.");
            return false; // Prevent form submission
        }

        // If at least one checkbox is checked or additionalComments has some content, allow form submission
        return true;
    }
</script>

  </body>
</html>