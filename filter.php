<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedCategory = $_POST["category"];

    // Modify the SQL query based on the selected category
    if ($selectedCategory == 'all') {
        $sql = "SELECT * FROM product";
    } else {
        $sql = "SELECT * FROM product WHERE categoryname = '$selectedCategory'";
    }

    // Execute the SQL query
    $result = mysqli_query($con, $sql);

    // Output the filtered product list
    while ($row = mysqli_fetch_assoc($result)) {
        // Output product HTML as you did before
    }
}
?>
