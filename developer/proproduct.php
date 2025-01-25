<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['developer_login_status']) || $_SESSION['developer_login_status'] !== "logged in" || !isset($_SESSION['developer_id'])) {
    header("Location:../login.php");
    exit(); // Ensure script stops execution after redirection
}

// Sign Out code
if (isset($_GET['sign']) && $_GET['sign'] === "out") {
    $_SESSION['developer_login_status'] = "logged out";
    unset($_SESSION['developer_id']);
    header("Location:../login.php");
    exit(); // Ensure script stops execution after redirection
}

// Include the database connection
include("../connect.php");

// Fetch categories from the category table
$categoryQuery = "SELECT categoryname FROM category";
$categoryResult = $con->query($categoryQuery);
$categories = [];

if ($categoryResult && $categoryResult->num_rows > 0) {
    while ($row = $categoryResult->fetch_assoc()) {
        $categories[] = $row['categoryname'];
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data (use appropriate validation/sanitization methods)
    $app_name = $_POST['app_name'];
    $description = $_POST['description'];
    $category = $_POST['categoryname'];
    $version = $_POST['version'];
    $price = $_POST['price'];
    $release_date = $_POST['release_date'];
    $developer_id = $_SESSION['developer_id'];
    $product_id = generateProductID();

    // Image upload handling
    $targetDir = "../image/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, move the uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Escape the values to prevent SQL injection
            $app_name = $con->real_escape_string($app_name);
            $description = $con->real_escape_string($description);
            $category = $con->real_escape_string($category);
            $version = $con->real_escape_string($version);
            $price = $con->real_escape_string($price);
            $release_date = $con->real_escape_string($release_date);
            $developer_id = $con->real_escape_string($developer_id);
            $product_id = $con->real_escape_string($product_id);
            $imagePath = $targetFile;

            // SQL query to insert data into the product table (use prepared statements for better security)
            $sql = "INSERT INTO product (product_id, app_name, description, categoryname, version, price, release_date, developer_id, image) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sssssssss", $product_id, $app_name, $description, $category, $version, $price, $release_date, $developer_id, $imagePath);

            if ($stmt->execute()) {
                echo "App information added successfully";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Close connection
    $con->close();
    exit(); // Ensure script stops execution after form processing
}

// Function to generate a unique product ID (replace with your logic)
function generateProductID() {
    return uniqid("app_", true);
}
?>
   

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add App Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            color: white;
        }

        header {
            background-color: white;
            color: black;
            text-align: center;
            padding: 1em;
        }

        section {
            max-width: 800px;
            margin: 2em auto;
            background-color: #00CBFE;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 0.5em;
            font-weight: bold;
        }
		select {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input, textarea {
            width: 100%;
            padding: 0.5em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 0.7em 1em;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
	
	 <!-- ... (Your existing head content) ... -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Listen for the change event on the category select
            $('#categoryname').change(function () {
                // Get the selected option value
                var selectedCategory = $(this).val();

                // Send an AJAX request to insert the selected category into the database
                $.ajax({
                    type: 'POST',
                    url: 'insert_category.php', // Replace with the actual server-side script to insert into the category table
                    data: { category: selectedCategory },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</head>
<body>

<header>
    <h2>Add App Information</h2>
	<a href="devhome.php"><button>Back</button></a>
</header>

<section>
    <form method="post" enctype="multipart/form-data">
        <!-- Add input field for image -->
        <label for="image">App Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <label for="app_name">App Name:</label>
        <input type="text" id="app_name" name="app_name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="categoryname">Category:</label>
        <select id="categoryname" name="categoryname" required>
            <?php
            foreach ($categories as $categoryOption) {
                echo "<option value='$categoryOption'>$categoryOption</option>";
            }
            ?>
        </select>
        <label for="version">Version:</label>
        <input type="text" id="version" name="version" rows="4" required>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>

        <label for="release_date">Release Date:</label>
        <input type="date" id="release_date" name="release_date" required>

        <input type="hidden" name="developer_id" value="<?php echo $_SESSION['developer_id']; ?>">

        <input type="hidden" name="product_id" value="<?php echo generateProductID(); ?>">

        <button type="submit">Add App</button>
    </form>
</section>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
