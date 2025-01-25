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

// Function to update data in the database
function updateData($con, $developer_id, $column, $new_value)
{
    // Check if the new value already exists in the database for the given column
    if ($column === 'mail' || $column === 'honenumber' || $column === 'developer_id') {
        $check_query = "SELECT COUNT(*) as count FROM developer WHERE $column = ?";
        $check_stmt = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $new_value);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_bind_result($check_stmt, $count);
        mysqli_stmt_fetch($check_stmt);
        mysqli_stmt_close($check_stmt);

        if ($count > 0) {
            $GLOBALS['error_message'] = "Update failed: The new value already exists.";
            return; // Exit the function if duplicate found
        }
    }

    // Update data in the database
    $query = "UPDATE developer SET $column = ? WHERE developer_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "si", $new_value, $developer_id);

    if (!mysqli_stmt_execute($stmt)) {
        $GLOBALS['error_message'] = "Update failed: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

// Handle form submissions for updating data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $developer_id = $_POST['developer_id'];
    $column = $_POST['column'];
    $new_value = $_POST['new_value'];

    // Attempt to update data
    updateData($con, $developer_id, $column, $new_value);
}

// Handle search query for developer ID
if (isset($_GET['search_developer_id'])) {
    $search_developer_id = mysqli_real_escape_string($con, $_GET['search_developer_id']);
    $query = "SELECT mage, developer_id, sername, mail, ateofbirth, honenumber, assword, status FROM developer WHERE developer_id = '$search_developer_id'";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
} else {
    // Default query to fetch all data
    $query = "SELECT mage, developer_id, sername, mail, ateofbirth, honenumber, assword, status FROM developer";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
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
				<h4>See All Developer Information</h4>
					<?php
						if ($_SERVER['REQUEST_METHOD'] === 'POST') {
							echo "<div class='error-message'>$error_message</div>";
						}
						?>
						<!-- Add search form -->
						<div class="search-container">
							<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<input type="text" name="search_developer_id" placeholder="Search by Developer ID">
								<input type="submit" value="Search">
							</form>
						</div>

						<div class="data-table-container table-responsive">
							<table class="data-table table table-bordered">
								<thead>
									<tr>
										<th>Developer Image</th>
										<th>Developer ID</th>
										<th>Username</th>
										<th>Email</th>
										<th>Date of Birth</th>
										<th>Phone Number</th>
										<th>Password</th>
										<th>Status</th>
										<th>Change Information</th>
										
									</tr>
								</thead>
								<tbody>
									<?php
									$index = 0; // Initialize an index variable
									while ($row = mysqli_fetch_assoc($result)) {
										echo "<tr>";
										$emage = $row['mage'];
											$imageFilePath = "../image/" . $emage;

											if (file_exists($imageFilePath)) {
												echo '<td><img src="' . $imageFilePath . '" alt="Developer Image"></td>';
											} else {
												echo '<td>Image file not found.</td>';
											}
										echo "<td style='color: black;'>" . htmlspecialchars($row['developer_id']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['sername']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['mail']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['ateofbirth']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['honenumber']) . "</td>";
										echo "<td style='color: black;'>" . htmlspecialchars($row['assword']) . "</td>";
										 
										echo "<td style='color: " . ($row['status'] == 1 ? 'green' : 'red') . ";'>"; 
										echo htmlspecialchars($row['status'] == 1 ? 'Active' : 'Inactive'); // Display the status

										// Form for updating the status
										echo "<form id='updateForm_$index' method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
										echo "<input type='hidden' name='developer_id' value='" . $row['developer_id'] . "'>";
										echo "<input type='hidden' name='column' value='status'>"; // Set the column to 'status'

										// Display different options based on the current status
										if ($row['status'] == 1) {
											echo "<input type='hidden' name='new_value' value='0'>";
											echo "<input type='submit' value='Make Inactive'>";
										} else {
											echo "<input type='hidden' name='new_value' value='1'>";
											echo "<input type='submit' value='Make Active'>";
										}

										echo "</form>";
										echo "</td>";

										echo "<td>";
										echo "<form id='updateForm_$index' method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
										echo "<input type='hidden' name='developer_id' value='" . $row['developer_id'] . "'>";
										echo "<select name='column'>
												<option value='sername'>Username</option>
												<option value='mail'>Email</option>
												<option value='ateofbirth'>Date of Birth</option>
												<option value='honenumber'>Phone Number</option>
												<option value='assword'>Password</option>
											  </select>";
										echo "<input type='text' name='new_value' placeholder='New Value'>";
										echo "<input type='submit' value='Update'>";
										echo "</form>";
										echo "</td>";
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
