<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, PublishPost, SQL Examples
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

//Defining variables referenced outside of below statements requred to set them in order to avoid "null error".
$success = "";
$error = "";

//When "submit", this happens.
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_POST['submit'])) {
	
	//Defining variables through form data and current session variables
	$userid = $_SESSION['id'];//<----Exchange variable to point to correct session variable here
	$username = $_SESSION['username'];//<----Exchange variable to point to correct session variable here
	$titel = mysqli_real_escape_string($mysqli_pointer, $_POST['title']);//<----Exchange variable to point to correct form data here
	$text = mysqli_real_escape_string($mysqli_pointer, $_POST['text']);//<----Exchange variable to point to correct form data here
	$category = mysqli_real_escape_string($mysqli_pointer, $_POST['category_type']);//<----Exchange variable to point to correct form data here
	
	//If form contains data
	if(!empty($titel) || !empty($text) || !empty($category)){//<----Exchange variables to corresponding REQUIRED form data here
		
		//<----Exchange query to point to correct database and table row below. this needs to correspond with form-collected data and session variables 
		$query = "INSERT INTO article(id, username, titel, text, category_type)
		VALUES('$userid', '$username', '$_GET[title]', '$_GET[text]', '$_GET[category_type]')";

		if (!mysqli_query($mysqli_pointer,$query)) {
			die('Error: ' . mysqli_error($mysqli_pointer));

			$success .= "User information succsessfully updated!";
		}
	}
	else{
		$error .= '<p class="error">Error: Field empty!</p>';
		die();
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
			User Post
		</title>
	</head>
	<body>
		<div id="userpost" class="userpost">
			<h1>
				Publish post
			</h1>
			<!--Form for user post-->
			<form id="userpublish" method="post" action="">
				<p class="form_text"><!--Post title as example-->
					<input type="text" id="Titel" name="Titel" placeholder="Title" required>
				</p>
				<p class="form_text"><!--Post content as example-->
					<textarea id="ArtikelContent" name="ArtikelContent" placeholder="Text" cols="100" rows="20" required></textarea>
				</p>
				<!--Collecting alternatives with AJAX and JSON-->
				<p class="form_text">
					<form action="" method="get">
						<label for="Category">Category:</label><!--Category as example-->
						<input list="Category" name="categories" id="categories"><!--Category as example, Categories as example-->
						<datalist id="Category"><!--Category as example-->
							<script type="JQuery">
								$(document).ready(function(){
									$.getJSON("categories.json", function(data) {<!--categories.json as an example, here you need to input name of the JSON-file which hosts and collects all the data you want to be able to display
										$(data).each(function(index, element) {
											categories = "<option value=\"" + this.Category + "\">" + "</option>";<!--categories as example, Category as example -->
											$('#Category').append(categories);<!--Category as example, categories as example -->
										});
									});
								});
							</script>
						</datalist>
						<br><br>
						<!--Submit button-->
						<input type="submit" name="submit" value="Submit">
					</form>
				</p>
			</form>
		</div>
	</body>
</html>
