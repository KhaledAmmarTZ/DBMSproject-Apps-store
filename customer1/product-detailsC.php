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



// Check if the product_id parameter is present in the URL
if (isset($_GET['product_id'])) {
    // Get the product ID from the URL
    $product_id = $_GET['product_id'];

    // Prepare and execute the SQL query to retrieve details of the specific product
    $sql = "SELECT product.*, developer.sername as developer_name 
            FROM product 
            JOIN developer ON product.developer_id = developer.developer_id 
            WHERE product.product_id = '$product_id'";

    $result = mysqli_query($con, $sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the details of the specific product along with the developer name
        $productDetails = mysqli_fetch_assoc($result);

        // Now you can use $productDetails to display information about the specific product
        // For example, echo $productDetails['app_name'], $productDetails['description'], etc.
        // The developer's name can be accessed as $productDetails['developer_name']
    } else {
        // Handle the case where the query was not successful
        echo "Error: " . mysqli_error($con);
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $product_id = $_POST['product_id'];
        $customer_id = $_SESSION['customer_id'];
        $rating = $_POST['rating'];
        $review = $_POST['review'];

        // Create a unique review_id by concatenating customer_id and product_id
        $review_id = $customer_id . '_' . $product_id;

        // Add or update the review in the database
        $stmt = $con->prepare("INSERT INTO review (review_id, customer_id, product_id, rating, comment) VALUES (?, ?, ?, ?, ?)
                                ON DUPLICATE KEY UPDATE rating = VALUES(rating), comment = VALUES(comment)");
        $stmt->bind_param("sssss", $review_id, $customer_id, $product_id, $rating, $review);
        $stmt->execute();
        $stmt->close();
		
		        // Calculate new values for trating and treviews
        $calculateRatingsQuery = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM review WHERE product_id = '$product_id'";
        $result = mysqli_query($con, $calculateRatingsQuery);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $avgRating = $row['avg_rating'];
            $totalReviews = $row['total_reviews'];

            // Update product table with new values
            $updateProductQuery = "UPDATE product SET trating = '$avgRating', treviews = '$totalReviews' WHERE product_id = '$product_id'";
            mysqli_query($con, $updateProductQuery);
        } else {
            // Handle the case where the query to calculate ratings was not successful
            echo "Error calculating ratings: " . mysqli_error($con);
        }
    

    }
	

    // Retrieve existing reviews for the product
    $reviews_query = $con->query("SELECT * FROM review WHERE product_id = '$product_id'");
    $reviews = $reviews_query->fetch_all(MYSQLI_ASSOC);
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
		.rating.rate {
			font-size: 14px;
			margin-top: 5px;
		}

		.rating.rate .star-ratingg {
			color: Blue; /* Adjust the color to your preference */
		}

		* {
			margin: 0;
			padding: 0;
		}

		.rate {
			float: left;
			height: 46px;
			padding: 0 10px;
		}

		.rate:not(:checked) > input {
			position:absolute;
			top:-9999px;
		}

		.rate:not(:checked) > label {
			float:right;
			width:1em;
			overflow:hidden;
			white-space:nowrap;
			cursor:pointer;
			font-size:30px;
			color:#ccc;
		}

		.rate:not(:checked) > label:before {
			content: '★ ';
		}

		.rate > input:checked ~ label {
			color: #ffc700;    
		}

		.rate:not(:checked) > label:hover,
		.rate:not(:checked) > label:hover ~ label {
			color: #deb217;  
		}

		.rate > input:checked + label:hover,
		.rate > input:checked + label:hover ~ label,
		.rate > input:checked ~ label:hover,
		.rate > input:checked ~ label:hover ~ label,
		.rate > label:hover ~ input:checked ~ label {
			color: #c59b08;
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

    <div class="single-product section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-image">
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

                <div class="col-lg-6 align-self-center">
                    <div class="product-details">
                        
						<?php
						echo '<h4 style="display: inline;">' . (isset($productDetails['app_name']) ? $productDetails['app_name'] : 'Product Not Found') . '</h4>';

						 // Display star rating if available
						if (isset($productDetails['trating'])) {
							echo '<div class="rating rate">' . displayStarRating($productDetails['trating']) . '</div>';
						}
						?>
                    </div>

                    <span class="price"><?php echo isset($productDetails) ? '$' . $productDetails['price'] : 'Product Not Found'; ?></span>

                    <p><?php echo isset($productDetails) ? $productDetails['description'] : 'Product Not Found'; ?></p>
                    <p><span>Downloads:</span><?php echo isset($productDetails) ? $productDetails['download_count'] : 'Product Not Found'; ?></p>
					<form id="qty" action="placeholder_action.php" method="post">
						<?php
						// Check if the product is found
						if (isset($productDetails['product_id'])) {
							echo '<button type="button" onclick="window.location.href=\'download.php?product_id=' . $productDetails['product_id'] . '\';"><i class="fa fa-shopping-bag" style="margin-left: 5px;"></i> Download</button>';
							
						} else {
							echo 'No products found';
						}
						?>

                    
					</form>




                    <ul>
                        <li><span>Developer Name:</span><?php echo isset($productDetails) ? ' ' . $productDetails['developer_name'] : ' Product Not Found'; ?></li>
                        <li><span>Game ID:</span><?php echo isset($productDetails) ? ' ' . $productDetails['product_id'] : ' Product Not Found'; ?></li>
                        <li><span>Genre:</span><?php echo isset($productDetails) ? ' ' . $productDetails['categoryname'] : ' Product Not Found'; ?></li>
                    </ul>
                </div>
				

                <div class="col-lg-12">
                    <div class="sep"></div>
                </div>
            </div>
        </div>
    </div>
<?php
	// Add the displayStarRating function here
	function displayStarRating($rating)
	{
		$output = '';

		// Split the rating into integer and decimal parts
		$integerPart = floor($rating);
		$decimalPart = $rating - $integerPart;

		// Display full stars
		for ($i = 1; $i <= $integerPart; $i++) {
			$output .= '<span class="fas fa-star star-ratingg"></span>';
		}

		// Display half star if the decimal part is greater than 0
		if ($decimalPart > 0) {
			$output .= '<span class="fas fa-star-half-alt star-ratingg"></span>';
		}

		// Calculate the remaining empty stars
		$remainingStars = 5 - $integerPart - ($decimalPart > 0 ? 1 : 0);

		// Display remaining empty stars
		for ($i = 1; $i <= $remainingStars; $i++) {
			$output .= '<span class="far fa-star star-ratingg"></span>';
		}

		return $output;
	}
	?>	
    <div class="container">
		<div class="main-button">
			<?php
			// Check if the product is found
			if (isset($productDetails['product_id'])) {
				echo '<button type="button" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href=\'rating.php?product_id=' . $productDetails['product_id'] . '\';">Add A Review</button>';
				echo '<button type="button" style="background-color: red ; color: white; padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer;" onclick="window.location.href=\'chreport.php?product_id=' . $productDetails['product_id'] . '\';">Report This</button>';
			} else {
				echo 'No products found';
			}
			?>
		</div>
	</div>


    
	<div class="more-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-content">
                    <div class="row">
                        <div class="nav-wrapper">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false"><?php echo isset($productDetails) ? $productDetails['treviews'] : 'Product Not Found'; ?> Reviews</button>
                                </li>
                            </ul>
                        </div>              
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <?php foreach ($reviews as $review) : ?>
                                    <div class="user-review">
                                        <p><strong>User Name:<?php echo getCustomerName($review['customer_id']); ?></strong></p>
                                        <p class="rating">Rating: <?php echo displayStarRating($review['rating']); ?></p>
                                        <p>Comment:<?php echo $review['comment']; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <script>
        // JavaScript to handle star rating
        document.addEventListener("DOMContentLoaded", function () {
            const stars = document.querySelectorAll('.star-rating input');
            stars.forEach(function (star) {
                star.addEventListener('change', function () {
                    this.parentNode.setAttribute('data-rating', this.value);
                });
            });
        });
    </script>
	<script>
		function validateForm() {
			// Check if the rating is selected
			var rating = document.querySelector('input[name="rating"]:checked');
			if (!rating) {
				alert("Please select a rating.");
				return false; // Prevent form submission
			}

			// Check if the review is provided
			var review = document.getElementById('review').value.trim();
			if (review === '') {
				alert("Please provide a review.");
				return false; // Prevent form submission
			}

			// If both rating and review are provided, allow form submission
			return true;
		}
	</script>


    

	<?php
	function getCustomerName($customer_id)
	{
		// Include your database connection file
		include("../connect.php");

		// Prepare and execute the SQL query to retrieve the customer name
		$sql = "SELECT usernam FROM customer WHERE customer_id = ?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("s", $customer_id);
		$stmt->execute();
		$stmt->bind_result($customer_name);

		// Fetch the customer name
		$stmt->fetch();

		// Close the statement and connection
		$stmt->close();
		$con->close();

		return isset($customer_name) ? $customer_name : "Unknown Customer";
	}
	?>

    <div class="section most-played">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-heading">
                        <h6>TOP GAMES</h6>
                        <h2>Most Played</h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="main-button">
                        <a href="shopC.php">View All</a>
                    </div>
                </div>

                <?php
                // Fetch the top 2 downloads
                $topDownloadsQuery = "SELECT app_name, categoryname, download_count, image,product_id FROM product ORDER BY download_count DESC LIMIT 6";
                $topDownloadsResult = mysqli_query($con, $topDownloadsQuery);

                // Loop through the top downloads and display them
                while ($row = mysqli_fetch_assoc($topDownloadsResult)) {
                    echo '<div class="col-lg-2 col-md-6 col-sm-6">';
                    echo '<div class="item">';
                    echo '<div class="thumb">';
                    $imageFilePath = "../image/" . $row['image'];
                    if (file_exists($imageFilePath)) {
                        echo '<a href="product-detailsC.php?product_id=' . $row['product_id'] . '"><img src="' . $imageFilePath . '" alt=""></a>';
                    } else {
                        echo 'Image file not found.';
                    }
                    echo '</div>';
                    echo '<div class="down-content">';
                    echo '<h4>' . $row["app_name"] . '</h4>';
                    echo '<span class="category">' . $row["categoryname"] . '</span>';
                    if (isset($row['download_count'])) {
                        echo '<div class="download-count">Downloads: ' . $row['download_count'] . '</div>';
                    }
					echo '<a href="product-detailsC.php?product_id=' . $row['product_id'] . '">Explore</a>';
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>

            </div>
        </div>
    </div>

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
