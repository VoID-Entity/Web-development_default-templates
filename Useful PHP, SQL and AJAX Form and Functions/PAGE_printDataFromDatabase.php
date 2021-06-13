<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, PrintDatabase, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

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

//------------------------------------------------------------------------------------

?>

<!DOCTYPE html>

<html>
	<head>
		<!--Character Encoding Table-->
		<meta charset="UTF-8">
		<!--Link to CSS file-->
		<link href="style.css" rel="stylesheet">
		<!--Link to jQuery scripts-->
		<script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<title>
			List Data
		</title>
	</head>
	<body>
		<div id="listData" class="listData">
			<h1>
				<center>
					Choose a user:
				</center>
			</h1>
			<!--Collecting alternatives with AJAX and JSON-->
			<form action="" method="get">
				<label for="users">Users:</label><!--users as example-->
				<input list="users" name="user" id="user"><!--users as example-->
				<datalist id="users"><!--users as example-->
					<script type="JQuery">
						$(document).ready(function(){
							$.getJSON("userinfo.json", function(data) {<!--userinfo.json as an example, here you need to input name of the JSON-file which hosts and collects all the data you want to be able to display-->
								$(data).each(function(index, element) {
									user = "<option value=\"" + this.Username + "\">" + this.ID + "</option>";<!--user as example, Username as example, ID as example, here you need to exchange variables to to point to corresponding rows defined in JSON file-->
									$('#users').append(user);<!--$users as example, user as example-->
								});
							});
						});
					</script>
				</datalist>
				<!--Submit button-->
				<input type="submit" name="submit" value="Submit">
			</form>
			<p>
				<?php
					if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user'])) {//<--user as example
						$namn = $_GET["user"]; //<--user as example
						
						echo '<h1>', 'User: ', $_GET["user"], '</h1>';//<--user as example
						
						//Connection to database if "databaseConnection.php" is included
						$mysqli_pointer = new mysqli(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);//<-----Enter variables defined in "databaseConnection.php" here
						if (mysqli_connect_errno()){
							echo'<p class="error">Something went wrong: </p>' . mysqli_connect_error();
						}
						//Query
						if($query = $mysqli_pointer->prepare("SELECT * FROM userinfo WHERE users_username = ?")) {//<----Exchange query to point to correct database and row for what you want to display here
							$query->bind_param('s', $namn);//<---Binding variable as string
							$query->execute();//<----Execute
							$rad = $query->get_result()->fetch_assoc();//<----Fetching result and associated data
						} 
						//Printing result
						echo 'User ID: '. $rad['users_id']. '<br>'. " ". 'Name: '. $rad['surname']. " ". $rad['lastname']. '<br>'. " ". 'Age: '. $rad['age']. '<br>'. " ". 'Location: '. $rad['city']. '<br>'. " ". 'Presentation: '. $rad['presentation'];
					}
					// Closing connection to database
					$query->close();
					$insertQuery->close();
					mysqli_close($mysqli_pointer);
				?>
			</p>
		</div>
	</body>
</html>