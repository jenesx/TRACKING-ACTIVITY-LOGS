<?php  
require_once 'models.php'; 
require_once 'handleforms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>REGISTER</title>
	<link rel="stylesheet" href="styles.css"> 
	<style>
		/* General styling */
        body {
            font-family: Times New Roman, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center; 
            background-color: #f0f8ff;
        }

       
        .login-container {
            max-width: 400px;
            margin: 50px auto; 
            padding: 20px;
            border: 2px solid #6a0dad; 
            border-radius: 10px;
            background-color: #f0f8ff; 
        }

        .login-container h1 {
            color: #6a0dad; 
            margin-bottom: 20px;
        }

        .login-container input[type="text"], 
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-container input[type="submit"] {
            background-color: #6a0dad;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 95%;
        }

        .login-container input[type="submit"]:hover {
            background-color: #9370db; 
        }

        a {
            color: #6a0dad;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
	</style>
</head>
<body>
	<h1>REGISTER HERE</h1>
	<?php  
	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

		if ($_SESSION['status'] == "200") {
			echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
		}

		else {
			echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
		}

	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
	<form action="handleforms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username">
		</p>
		<p>
			<label for="username">First Name</label>
			<input type="text" name="first_name">
		</p>
		<p>
			<label for="username">Last Name</label>
			<input type="text" name="last_name">
		</p>
		<p>
			<label for="username">Password</label>
			<input type="password" name="password">
		</p>
		<p>
			<label for="username">Confirm Password</label>
			<input type="password" name="confirm_password">
			<input type="submit" name="insertNewUserBtn">
		</p>
	</form>
</body>
</html>