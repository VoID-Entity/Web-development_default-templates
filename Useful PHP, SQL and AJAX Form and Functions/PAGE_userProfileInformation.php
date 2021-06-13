<?php

//Require session file to access variables for current session
require "session.php";//<------Name of file to access session variables

//Require database-connection file to access login credentials
require_once "databaseConnection.php";//<------Name of file with database access credentials

//------------------------------------------------------------------------------------

	//---->ALTERNATIVELY<----\\
	
//Include credentials to database if this is not stored in a seperate file
//$mysqli_pointer = mysqli_connect("localhost","USERNAME","PASSWORD", "DATABASE");//<-----Here you enter your login credential etc to access database
//if (mysqli_connect_errno()){
//	$error .= '<p class="error">Something went wrong: </p>' . mysqli_connect_error();
//}

//----------------------------------------------------------------------------------

//Defining variables referenced outside of below statements requred to set them in order to avoid "null error".
$success = "";
$error = "";

//Defining variable for comparison against database
$refname = $_SESSION["username"];

//When "submit", this happens.
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['submit'])) {
	
	//Defining variables through form and current session
	$id = $_SESSION['id'];//<----Exchange variable to point to correct session variable here
	$username = $_SESSION['username'];//<----Exchange variable to point to correct session variable here
	$surname = mysqli_real_escape_string($mysqli_pointer, $_GET["surname"]);//<----Exchange variable to point to correct form variable here
	$age = mysqli_real_escape_string($mysqli_pointer, $_GET["age"]);//<----Exchange variable to point to correct form variable here
	$city = mysqli_real_escape_string($mysqli_pointer, $_GET["city"]);//<----Exchange variable to point to correct form variable here
	$Presentation = mysqli_real_escape_string($mysqli_pointer, $_GET["presentation"]);//<----Exchange variable to point to correct form variable here
	
	//If form contains data
	if(!empty($surname) || !empty($age) || !empty($city) || !empty($presentation)){//<----Exchange variables to corresponding REQUIRED form data here
		
		//Query to check if table contains data associated with current(SESSION) username
		if($query = $mysql_pointer->prepare("SELECT * FROM userinfo WHERE users_username = ?")) {//<----Exchange query to point to correct database and row for what you want to fetch here
		
			//Bind parameter for username as string
			$query->bind_param('s', $refname);
			$row = $query->get_result()->fetch_assoc();//<---Fetch result and associated information
			
			//If result contains data, this code excutes and updates data in selected table
			if($row) {
				
				//<----Exchange query to point to correct database and table row below. this needs to correspond with form-collected data and session variables
				$query = "UPDATE userinfo SET users_id = '$id',
				users_username = '$username',
				surname = '$_GET[surname]',
				lastname = '$_GET[lastname]',
				age = '$_GET[age]',
				city = '$_GET[city]',
				presentation = '$_GET[Presentation]',
				ProfilePictures_Pictures_PictureID = '2'
				WHERE users_username = '$refname'";
				if (!mysqli_query($mysqli_pointer,$query)) {
					die('Error: ' . mysqli_error($mysqli_pointer));
				}
				else{
					$success .= "User information succsessfully updated!";
				}
			}
			//If "no result", this code executes and inserts data into selected table
			else {
				
				//<----Exchange query to point to correct database and table row below. this needs to correspond with form-collected data and session variables
				$query = "INSERT INTO userinfo(users_id, users_username, surname, lastname, age, city, presentation, ProfilePictures_Pictures_PictureID)
				VALUES('$id', '$username', '$_GET[surname]', '$_GET[lastname]', '$_GET[age]', '$_GET[city]', '$_GET[Presentation]', '2')";
				if (!mysqli_query($mysqli_pointer,$query)) {
					die('Error: ' . mysqli_error($mysqli_pointer));
				}
				else{
					$success .= "User information succsessfully updated!";
				}
				
			}	
		}
	}
	else{
		$error .= '<p class="error">Error: Field empty!</p>';
		die();
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
			User Information
		</title>
	</head>
	<body>
		<div id="userinfo" class="userinfo">
			<form id="contact" method="get" action="">
				<h3>
					Tell us about yourself
				</h3>
				<!--Print result when submit-->
				<?php echo $success; ?>
				<?php echo $error; ?>
				<!--Form for user information-->
				<p class="form_text"><!--surname as example-->
					<input type="text" id="surname" name="surname" placeholder="Surname" required>
				</p>
				<p class="form_text"><!--lastname as example-->
					<input type="text" id="lastname" name="lastname" placeholder="lastname" required>
				</p>
				<p class="form_text"><!--age as example-->
					<input type="int" id="age" name="age" placeholder="Age" required>
				</p>
				<p class="form_text"><!--text as example-->
					<input type="text" id="city" name="city" placeholder="City" required>
				</p>
				<p class="form_text"><!--presentation as example-->
					<textarea id="presentation" name="presentation" placeholder="Presentation" cols="45" rows="5" required></textarea>
				</p>
				<p class="form_text"><!--Submit button-->
					<input type="submit" name="submit" value="Submit">
				</p>
			</form>
		</div>
	</body>
</html>