<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, SearchDatabase, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

//require session file storing variables for current session
require "session.php";//<------Name of file storing session variables

//Requiring file containing credentials to the database hosting user login credentials
require_once 'databaseConnection.php';//<------Name of file with database access credentials
	
	//Connection to database if "databaseConnection.php" is included
	$connection = new mysqli(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);//<-----Here you enter variables stored in "databaseConnection.php"
	if ($connection->connect_error){
		die($connection->connect_error);
	}
	
//------------------------------------------------------------------------------------

	//---->ALTERNATIVELY<----\\
	
//Include credentials to database if this is not stored in a seperate file
//$mysqli_pointer = mysqli_connect("localhost","USERNAME","PASSWORD", "DATABASE");//<-----Here you enter your login credential etc to access database
//if (mysqli_connect_errno()){
//	$error .= '<p class="error">Something went wrong: </p>' . mysqli_connect_error();
//}

//------------------------------------------------------------------------------------
	
//Defining variables referenced outside of below statements requred to set them in order to avoid "null error".
$search = "";
$row = "";

//When "submit", this happens.
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
	
	$search = mysqli_real_escape_string($mysqli_pointer, $_POST['search']);//<----Here you exchange variable to point to correct form variable
	
	if($query = $mysql_pointer->prepare("SELECT * FROM users WHERE username = ?")) {{//<----Here you exchange query to point to correct database and row for search results
		$query->bind_param('s', $search);//<---Bind parameter for search as string
		$query->execute();//<---Execute
		$row = $query->get_result()->fetch_assoc();//<----Fetching result and associated data
	}
	//Closing connection to database
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
		<!--Link to CSS fil-->
		<link href="style.css" rel="stylesheet">
		<!--Link to jQuery scripts-->
		<script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<title>
			Search user information
		</title>
	</head>
	<body>
		<div id="search" class="search">
			<h1>
				<center>
					Search user information
				</center>
			</h1>
			<h3>
				<!--Print searchterm when submit-->
				<?php echo 'Search results for: '. $search ?>
			</h3>
			<p>
				<!--Print result when submit-->
				<?php 
					if($row) {//<--Below is an example of printed result, these ofc has to be changed to point to rows in your database corresponding to available search querys.
						echo 'UserID: ' . $row['id'] .'<br>' . ' Username: '. $row['username'] .'<br>' . ' Email:  ' . $row["email"] . '<br><br>';
					}
					else {
						echo "No Results!";
					}
				?>
			</p>
			<!--Form for search-->
			<form id="contact" method="post" action="">
				<p class="form_text"><!--Searchbar-->
					<input type="search" name="search" placeholder="Search">
				</p>
				<p class="form_text"><!--Submit button-->
					<input type="submit" name="submit" value="Submit">
				</p>
			</form>
		</div>
	</body>
</html>