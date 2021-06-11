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

//require session file storing variables for current session
require "session.php";//<------Name of file storing session variables

//Requiring file containing credentials to the database hosting user login credentials
require_once 'databaseConnection.php';//<------Name of file with database access credentials

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
		<!--Link to CSS fil-->
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
							$.getJSON("userinfo.json", function(data) {<!--userinfo.json as example, here you need to set name for JSON file storing data you wantt collect from the database
								$(data).each(function(index, element) {
									user = "<option value=\"" + this.Username + "\">" + this.ID + "</option>";<!--user as example, Username as example, ID as example-->
									$('#users').append(user);
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
						$connection = new mysqli(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);//<-----Here you enter variables stored in "databaseConnection.php"
						if (mysqli_connect_errno()){
							echo'<p class="error">Something went wrong: </p>' . mysqli_connect_error();
						}//Query to store result
						if($query = $mysql_pointer->prepare("SELECT * FROM userinfo WHERE users_username = ?")) {//<----Here you exchange query to point to correct database and row for what you want to display
							$query->bind_param('s', $namn);//<---Binding variable as string
							$query->execute();//<----Execute
							$rad = $query->get_result()->fetch_assoc();//<----Fetching result and associated data
						} 
						//Printing result
						echo 'User ID: '. $rad['users_id']. '<br>'. " ". 'Name: '. $rad['surname']. " ". $rad['lastname']. '<br>'. " ". 'Age: '. $rad['age']. '<br>'. " ". 'Location: '. $rad['city']. '<br>'. " ". 'Presentation: '. $rad['presentation'];
					}
				?>
			</p>
		</div>
	</body>
</html>