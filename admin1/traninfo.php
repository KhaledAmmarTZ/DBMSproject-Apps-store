<?php
session_start();

if ($_SESSION['admin_login_status'] != "logged in" and !isset($_SESSION['admin_id']))
    header("Location:../login.php");

// Sign Out code
if (isset($_GET['sign']) and $_GET['sign'] == "out") {
    $_SESSION['admin_login_status'] = "logged out";
    unset($_SESSION['admin_id']);
    header("Location:../login.php");
}

include('../connect.php');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$error_message = ""; // Initialize error message


// Handle search query for product ID
if (isset($_GET['search_product_id'])) {
    $search_product_id = mysqli_real_escape_string($con, $_GET['search_product_id']);
    $query = "SELECT product.image, 
                  product.product_id, 
                  product.app_name, 
                  product.developer_id,
                  transaction.transaction_id,
                  transaction.transaction_date,
                  transaction.transaction_amount,
                  customer.customer_id,
                  customer.usernam 
          FROM product
          JOIN transaction ON product.product_id = transaction.product_id
          JOIN customer ON transaction.customer_id = customer.customer_id
          WHERE customer.customer_id = '$search_product_id' OR product.product_id = '$search_product_id' OR transaction.transaction_id='$search_product_id'";

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
} else {
    // Default query to fetch all data
    $query = "SELECT product.image, 
                  product.product_id, 
                  product.app_name, 
                  product.developer_id,
                  transaction.transaction_id,
                  transaction.transaction_date,
                  transaction.transaction_amount,
                  customer.customer_id,
                  customer.usernam 
          FROM product
          JOIN transaction ON product.product_id = transaction.product_id
          JOIN customer ON transaction.customer_id = customer.customer_id";

    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
}
?>
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
	
    /* Optional: Style for form elements */
    .data-table-container table.data-table select,
    .data-table-container table.data-table input[type="text"],
    .data-table-container table.data-table input[type="submit"] {
        color: blue; /* Set the text color for form elements */
        /* Add any additional styling for form elements if needed */
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
				 <h4>See All Transaction Information</h4>
					<?php
						if ($_SERVER['REQUEST_METHOD'] === 'POST') {
							echo "<div class='error-message'>$error_message</div>";
						}
						?>
						<!-- Add search form -->
						<div class="search-container">
							<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<input type="text" name="search_product_id" placeholder="Search by Pro,Cus,Tra ID">
								<input type="submit" value="Search">
							</form>
						</div>

						<div class=" data-table-container table-responsive">
							<table class="data-table table table-bordered">
								<thead>
									<tr>
										<th>Product Image</th>
										<th>Product ID</th>
										<th>APP name</th>
										<th>Devloper ID</th>
										<th>Customer ID</th>
										<th>Transaction ID</th>
										<th>Customer Name</th>
										<th>Transaction Date</th>
										<th>Transaction Amount</th>
										
										
									</tr>
								</thead>
								<tbody>
									<?php
									$index = 0; // Initialize an index variable
									while ($row = mysqli_fetch_assoc($result)) {
										
										echo "<tr>";
											$emage = $row['image'];
											$imageFilePath = "../image/" . $emage;

											if (file_exists($imageFilePath)) {
												echo '<td><img src="' . $imageFilePath . '" alt="product Image"></td>';
											} else {
												echo '<td>Image file not found.</td>';
											}
										echo "<td style='color: black;'>" . htmlspecialchars($row['product_id']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['app_name']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['developer_id']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['customer_id']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['transaction_id']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['usernam']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['transaction_date']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['transaction_amount']) . "</td>";
										
										
										
										
										echo "</tr>";
										$index++; // Increment the index for each row
									}
									mysqli_close($con);
									?>
								</tbody>
							</table>
						</div>
				      <div class="back-button">
					<button onclick="navigateToPage('<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>')">Back</button>
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
