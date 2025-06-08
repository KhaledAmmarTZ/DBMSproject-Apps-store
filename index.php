<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
		body {
		font-family: Arial, sans-serif;
		background-image: url('Screenshot (11).png'); /* Specify the path to your background image */
		background-size: cover; /* Adjust the size of the background image */
		background-position: center; /* Center the background image */
		margin: 0;
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100vh;
		}

        .home-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .home-container h2 {
            margin-bottom: 20px;
        }

        .home-link {
            margin-top: 10px;
        }

        .home-link a {
            padding: 10px;
            margin: 0 10px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .home-link a:hover {
            background-color: #00CBFE;
        }
		 .logout-btn {
            background-color: #00CBFE;
            color: #00CBFE;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .logout-btn:hover {
            background-color: #00CBFE;
        }
    </style>
</head>
<body>

<div class="home-container">
    <h2>Welcome to the DBMS PROJECT</h2>
    <div class="home-link">
        <a href="shop.php">Go</a>
		
    </div>
	
</div>
	
</body>
</html>
