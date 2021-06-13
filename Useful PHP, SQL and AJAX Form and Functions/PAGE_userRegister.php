<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, RegisterUser, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

//Require database-connection file to access login credentials
require_once "databaseConnection.php";//<------Name of file with database access credentials

//------------------------------------------------------------------------------------

	//---->ALTERNATIVELY<----\\
	
//Include credentials to database if this is not stored in a seperate file
//$mysqli_pointer = mysqli_connect("localhost","USERNAME","PASSWORD", "DATABASE");//<-----Enter login credential etc to access database here
//if (mysqli_connect_errno()){
//	$error .= '<p class="error">Something went wrong: </p>' . mysqli_connect_error();
//}

//------------------------------------------------------------------------------------


//Defining variables referenced outside of below statement required to set them, this in order to avoid "null error".
$success = "";
$error = "";

//When "submit", this happens.
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
	
	//Defining variables through form data
	$username = mysqli_real_escape_string($mysqli_pointer, $_POST['username']);
	$email = mysqli_real_escape_string($mysqli_pointer, $_POST['email']);
	$password = mysqli_real_escape_string($mysqli_pointer, $_POST['password']);
	$confirm_password = mysqli_real_escape_string($mysqli_pointer, $_POST['confirm_password']);
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	
	if($query = $mysqli_pointer->prepare("SELECT * FROM users WHERE email = ?")) {//<----Exchange query to point to correct database and row for user login credentials here
		$error = '';
		
		//Bind parameter for email as string
		$query->bind_param('s', $email);
		$query->execute();
		
		//Saving result for comparison with database
		$query->store_result();
		
		//If email already exists in database
		if($query->num_rows > 0) {
			$error .= '<p class="error">This email address is already registered!</p>';
		}
		else {
			//Validate that password is longer than 6 characters
			if(strlen($password ) < 6) {
				$error .= '<p class="error">Password must have atleast 6 characters</p>';
			}
			
			//Confirming password
			if(empty($confirm_password)) {
				$error .= '<p class="error">Please confirm password!</p>';
			}
			//If "no match"
			else {
				if(empty($error) && ($password != $confirm_password)) {
					$error .= '<p class="error">Password did not match!</p>';
				}
			}
			//Insert user registration data into database
			if(empty($error) ) {
				$insertQuery = $mysqli_pointer->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?);");//<----Exchange query to point to correct database and row for user login credentials here
				$insertQuery->bind_param("sss", $username, $email, $password_hash);//<---Binding parameters
				$result = $insertQuery->execute();//<---Execute
				if($result) {
					$error .= '<p class="success">Your registration was successful!</p>';
				}
				else {
					$error .= '<p class="error">Something went wrong!</p>';
				}
			}
		}
	}
	// Closing connection to database
	$query->close();
	$insertQuery->close();
	mysqli_close($mysqli_pointer);
}
?>

<!DOCTYPE html>

<html>
	<head>
		<!--Character Encoding Table-->
		<meta charset="UTF-8">
		<!--Link to CSS file-->
		<link href="style.css" rel="stylesheet">
		<title>
			User registration
		</title>
	</head>
	<body>
		<div id="registration" class="registration">
			<h3>
				Register
			</h3>
			<p>
				Create account:
			</p>
			<!--Print result when submit-->
			<?php echo $success; ?>
			<?php echo $error; ?>
			<!--User registration form-->
			<form id="contact" method="post" action="">
				<p class="form_text"><!--Username form-->
					<input type="text" id="username" name="username" placeholder="Username" required>
				</p>
				<p class="form_text"><!--Email form-->
					<input type="email" id="email" name="email" placeholder="Email" required>
				</p>
				<p class="form_text"><!--Password form-->
					<input type="password" id="password" name="password" placeholder="Password" required>
				</p>
				<p class="form_text"><!--Password form-->
					<input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
				</p>
				<p class="form_text"><!--Submit button-->
					<input type="submit" name="submit" value="Submit">
				</p>
				<p><!--Direct user to login page if "already have account"-->
					Already have an account? <a href="login.php">Login here<a><!--Name of page containing user login form-->
				</p>
			</form>
		</div>
	</body>
</html>