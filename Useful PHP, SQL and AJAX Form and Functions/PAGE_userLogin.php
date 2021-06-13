<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, UserLogin, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

//Starts session
session_start();

//Require database-connection file to access login credentials
require_once "databaseConnection.php";//<------Name of file with database access credentials

//Defining variables referenced outside of below statements requred to set them in order to avoid "null error".
$success = "";
$error = "";

//When "submit", this happens.
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
	
	//Defining variables through form data
	$email = mysqli_real_escape_string($mysqli_pointer, $_POST['email']);
	$password = mysqli_real_escape_string($mysqli_pointer, $_POST['password']);
	
	//Error if field is empty (however, this field is required to be set by below html form)
	if(empty($email)) {
		$error .= '<p class="error">Please enter email address!</p>';
	}
	//Error if field is empty (however, this field is required to be set by below html form)
	if(empty($password)) {
		$error .= '<p class="error">Please enter password!</p>';
	}
	
	//Login (Comparing credentials from form to credentials hosted in database)
	if(empty($error)) {
		if($query = $mysqli_pointer->prepare("SELECT * FROM users WHERE email = ?")) {//<----Exchange query to point to correct database and row for user login credentials here 
			$query->bind_param('s', $email);//<-----Binding parameter "email" as string
			$query->execute();//<------Execute 
			$row = $query->get_result()->fetch_assoc();//<----Fetching result and associated data
			if($row) {
				if(password_verify($password, $row['password'])) {//<----If password is correct, this happens.
					
					//Defining session variables
					$_SESSION["id"] = $row['id'];
					$_SESSION["username"] = $row['username'];
					
					//Points to welcome.php (or whatever page you want successfully logged in users to be redirected to)
					header("location: welcome.php");//<-----Filename for page here
					exit;
				}
				else {
					$error .= '<p class="error">Invalid username or password</p>';
				}
			}
			else {
				$error .= '<p class="error">Invalid username or password</p>';
			}
		}
		$query->close();
	}
	//Closing connection to database.
	mysqli_close($mysqli_pointer);
}
?>

<!DOCTYPE html>

<html>
	<html>
	<head>
		<!--Character Encoding Table-->
		<meta charset="UTF-8">
		<!--Link to CSS fil-->
		<link href="style.css" rel="stylesheet">
		<title>
			User Login
		</title>
	</head>
	<body>
		<div id="login" class="login">
			<h3>
				Login
			</h3>
			<!--Print result when submit-->
			<?php echo $success; ?>
			<?php echo $error; ?>
			<!--Form for user login credentials-->
			<form id="contact" method="post" action="">
				<p class="form_text"><!--Email form-->
					<input type="email" id="email" name="email" placeholder="Email" required>
				</p>
				<p class="form_text"><!--Password form-->
					<input type="password" id="password" name="password" placeholder="Password" required>
				</p>
				<p class="form_text"><!--Submit button-->
					<input type="submit" name="submit" value="Submit">
				</p>
				<p><!--Direct user to register page if no account-->
					Don't have an account? <a href="register.php">Register here<a><!--Name of page containing user registration form-->
				</p>
			</form>
		</div>
	</body>
</html>