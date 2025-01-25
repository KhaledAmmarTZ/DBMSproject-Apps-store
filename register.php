<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="style.css">
	<script>
        function redirectToRegistrationPage(role) {
            // Define the URLs for each registration page
            var registrationPages = {
                "admin": "admin_registration.php",
                "developer": "developer_registration.php",
                "customer": "customer_registration.php"
            };

            // Get the selected role and redirect to the corresponding registration page
            var registrationPage = registrationPages[role];
            if (registrationPage) {
                window.location.href = registrationPage;
            }
        }
    </script>
    </head>
<body class="animate-in">
	<video autoplay muted loop id="video-bg">
        <source src="Screenshot (5)_animation.mp4" type="video/mp4"> <!-- Replace 'your-looping-video.mp4' with your actual video file path -->
        Your browser does not support the video tag.
    </video>
<link rel="stylesheet" href="styles.css">
<div class="login-container">
    <h2><font color="white">Register</font></h2>
    <form class="login-form">
		<div class="role-options">
		 <label>
                    <input type="radio" name="role" value="admin" onclick="redirectToRegistrationPage('admin')">
                    <font color="white">Admin</font>  
                </label>
                <label>
                    <input type="radio" name="role" value="developer" onclick="redirectToRegistrationPage('developer')">
                    <font color="white">Developer</font>
                </label>
                <label>
                    <input type="radio" name="role" value="customer" onclick="redirectToRegistrationPage('customer')" >
                    <font color="white">Customer</font>
                </label>
		</div>
    </form> 
    <div class="login-link">
        <p><font color="white">Already have an account?</font> <a href="login.php">Login here</a></p>
    </div>
</div>

<script>
    function register() {
        // You can add your registration logic here
        var role = document.querySelector('input[name="role"]:checked').value;
		var username = document.getElementById('username').value;
		var email = document.getElementById('email').value;
		var dateOfBirth = document.getElementById('dateofbirth').value;
		var phoneNumber = document.getElementById('phonenumber').value;
		var password = document.getElementById('password').value;
		
		 // Placeholder logic - you should replace this with actual registration logic
		console.log('Registration Details:');
		console.log('Role:', role);
		console.log('Username:', username);
		console.log('Email:', email);
		console.log('Date of Birth:', dateOfBirth);
		console.log('Phone Number:', phoneNumber);
		console.log('Password:', password);

        // Example: Save the registration data
        alert("Registration successful! Username: " + username + ", Email: " + email);
    }
    function togglePassword() {
		var passwordInput = document.getElementById('password');
		var toggleButton = document.querySelector('.toggle-password');

		if (passwordInput.type === 'password') {
			passwordInput.type = 'text';
			toggleButton.textContent = 'Hide';
		} 
		else {
        passwordInput.type = 'password';
        toggleButton.textContent = 'Show';
		}
	}
	function register() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var email = document.getElementById("email").value;
        var role = document.querySelector('input[name="role"]:checked').value;

        // Example: Save the registration data and redirect based on the role
        switch (role) {
            case 'admin':
                alert("Admin registration successful! Username: " + username + ", Email: " + email);
                window.location.href = "boss_dashboard.php";
                break;
            case 'developer':
                alert("developer registration successful! Username: " + username + ", Email: " + email);
                window.location.href = "employee_dashboard.php";
                break;
            case 'customer':
                alert("Customer registration successful! Username: " + username + ", Email: " + email);
                window.location.href = "customer_dashboard.php";
                break;
            default:
                alert("Invalid role");
        }
    }
	window.addEventListener("beforeunload", function () {
	document.body.classList.add("animate-out");
	});
	
	
</script>
</body>
</html>
