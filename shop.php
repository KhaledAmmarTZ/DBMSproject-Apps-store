<?php
session_start();
include("connect.php");

// Fetch categories from the database
$categoryQuery = "SELECT * FROM category";
$categoryResult = mysqli_query($con, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

// Handle search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchAppName = $_POST["app_name"];
    $searchCategory = isset($_POST["category"]) ? $_POST["category"] : '';

    // Modify the SQL query based on the search parameters
    $sql = "SELECT * FROM product WHERE app_name LIKE '%$searchAppName%'";

    // Add the condition for the category if it's selected
    if (!empty($searchCategory)) {
        $sql .= " AND categoryname LIKE '%$searchCategory%'";
    }
} else {
    // Default query to fetch all products
    $sql = "SELECT * FROM product";
}

// Execute the SQL query
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Blue Gaming - Shop Page</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
	<style>
		.main-bannert {
		  background-image: url(..);
		  border-radius: 0px 0px 15px 150x;
		  background-position: center bottom;
		  background-repeat: no-repeat;
		  background-size: cover;
		  padding: 2px 0px;
		}

		.main-bannert .caption h6 {
		  font-size: 20px;
		  text-transform: uppercase;
		  color: #fff;
		  font-weight: 500;
		  letter-spacing: 0.5px;
		}

		.main-bannert .caption h2 {
		  font-size: 48px;
		  color: #fff;
		  margin-top: 20px;
		  position: relative;
		  padding-bottom: 5px;
		  margin-bottom: 40px;
		}

		.main-bannert .caption h2:after {
		  position: absolute;
		  background-image: url(../images/caption-dec.png);
		  width: 202px;
		  height: 12px;
		  content: '';
		  left: 125px;
		  bottom: 0;
		}

		.main-bannert .caption p {
		  color: #fff;
		  margin-bottom: 70px;
		}

		.main-bannert .caption form {
		  position: relative;
		  max-width: 450px;
		}

		.main-bannert .caption form input {
		  max-width: 450px;
		  width: 100%;
		  height: 50px;
		  outline: none;
		  border-radius: 25px;
		  background-color: #fff;
		  border: none;
		  padding: 0px 25px;
		  font-size: 14px;
		  color: #7a7a7a;
		}

		.main-bannert .caption form button {
		  display: inline-block;
		  height: 50px;
		  line-height: 50px;
		  background-color: #ee626b;
		  color: #fff;
		  font-size: 15px;
		  text-transform: uppercase;
		  font-weight: 500;
		  padding: 0px 25px;
		  border: none;
		  border-radius: 25px;
		  position: absolute;
		  right: 0;
		  top: 0;
		  transition: all .3s;
		}

		.main-bannert .caption form button:hover {
		  background-color: #0071f8;
		  
		 
		}
		.rating {
			font-size: 14px;
			margin-top: 5px;
		}

		.star-rating {
			color: Blue; /* Adjust the color to your preference */
		}
		.download-count {
			font-size: 14px;
			color: #555; /* Adjust the color to your preference */
			margin-top: 5px;
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
          <a href="shop.php" class="logo">
            <img src="assets/images/logo.png" alt="" style="width: 158px;">
          </a>
          <!-- ***** Logo End ***** -->
          <!-- ***** Menu Start ***** -->
          <ul class="nav">
            <li><a href="shop.php" class="active">Shop</a></li>
            
            <li><a href="contact.html">Contact Us</a></li>
            <li><a href="login.php">LOG IN</a></li>
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
      <div class="main-bannert">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="caption header-text">
                <div class="search-input">
                  <form id="search" method="post">
                    <input type="text" placeholder="Type App Name" id="app_name" name="app_name">
                    <button role="button">Search Now</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <h3>Our Shop</h3>
        
      </div>
    </div>
  </div>
</div>


<div class="section trending">
    <div class="container">
        <ul class="trending-filter">
            <li><a class="is_active" href="#!" data-filter="*">Show All</a></li>
			
			<?php
			// Loop through categories and generate filter links
			foreach ($categories as $category) {
				echo '<li>';
				echo '<a href="#!" data-filter=".' . $category["categoryname"] . '">' . $category["categoryname"] . '</a>';
				echo '</li>';
			}
			?>
        </ul>

        <div class="row trending-box">
            <?php
// Loop through the result set and display products
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="col-lg-3 col-md-6 mb-30 trending-items ' . $row["categoryname"] . '">';
    echo '<div class="item">';
    echo '<div class="thumb">';
    $imageFilePath = "image/"                                  . $row['image'];
    
    if (file_exists($imageFilePath)) {
        echo '<a href="product-details.php?product_id=' . $row['product_id'] . '"><img src="' . $imageFilePath . '" alt="Product Image"></a>';
    } else {
        echo 'Image file not found.';
    }

    
	echo '<div class="rating rate">*Rating: ';
	echo displayStarRating($row['trating']);
	echo '</div>';

    echo '<span class="price">$' . $row["price"] . '</span>';
    echo '</div>';
    echo '<div class="down-content">';
    echo '<h4>' . $row["app_name"] . '</h4>';
    echo '<span class="category">Category: ' . $row["categoryname"] . '</span>';
    
    echo '<a href="product-details.php?product_id=' . $row['product_id'] . '"><i class="fa fa-shopping-bag"></i></a>';
    
    if (isset($row['download_count'])) {
        echo '<div class="download-count">Downloads: ' . $row['download_count'] . '</div>';
    }
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>
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

        </div>
    </div>
</div>


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
          <a href="shop.php">View All</a>
        </div>
      </div>

      <?php
        // Fetch the top 2 downloads
        $topDownloadsQuery = "SELECT app_name, categoryname, download_count, image, product_id FROM product ORDER BY download_count DESC LIMIT 6";
        $topDownloadsResult = mysqli_query($con, $topDownloadsQuery);

        // Loop through the top downloads and display them
        while ($row = mysqli_fetch_assoc($topDownloadsResult)) {
          echo '<div class="col-lg-2 col-md-6 col-sm-6">';
          echo '<div class="item">';
          echo '<div class="thumb">';
          $imageFilePath = "image/" . $row['image'];
          if (file_exists($imageFilePath)) {
            echo '<a href="product-details.php?product_id=' . $row['product_id'] . '"><img src="' . $imageFilePath . '" alt=""></a>';
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
		  echo '<a href="product-details.php?product_id=' . $row['product_id'] . '">Explore</a>';
          
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
        <p>Copyright © Blue Gaming Company. All rights reserved. &nbsp;&nbsp; <a rel="nofollow" href="https://templatemo.com" target="_blank">Design: Khaled</a></p>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
  <script>
	$(document).ready(function(){
		// Initialize Isotope
		var $grid = $('.trending-box').isotope({
			itemSelector: '.trending-items',
			layoutMode: 'fitRows'
		});

		// Filter items on button click
		$('.trending-filter').on('click', 'a', function(e) {
			e.preventDefault();
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({ filter: filterValue });
		});

		// Add active class to the current button (highlight it)
		$('.trending-filter a').on('click', function() {
			$('.trending-filter a').removeClass('is_active');
			$(this).addClass('is_active');
		});
	});
   </script>


  </body>
</html>