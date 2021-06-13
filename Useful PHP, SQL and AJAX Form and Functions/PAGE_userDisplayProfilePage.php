<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, FetchUserInformationFromDB, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

//Require session file to access variables for current session
require "session.php";//<------Name of file to access session variables

//Defining variable for comparison against database
$userinfo = $_SESSION["username"]

//Below example is treated as if there are multiple different databases with seperated login-credentials required to access them.
//Such a structure would require multiple different connections which will be illustrated below.

?>

<!DOCTYPE html>

<html>
	<head>
		<!--Character Encoding Table-->
		<meta charset="UTF-8">
		<!--Link to CSS fil-->
		<link href="style.css" rel="stylesheet">
		<title>
			Display profile page
		</title>
	</head>
	<body>
		<!--Main element fetches posts published by current user in this example-->
		<div class="main">
			<article>
					<!--Print welcome + current session username set to variable-->
					<?php
						echo 'Welcome back '. $userinfo. '!';
					?>
					<!--Fecthing users published post-->
					<?php
						
						//Include credentials to database if this is not stored in a seperate file
						$mysqli_pointer = mysqli_connect("localhost","USERNAME","PASSWORD", "DATABASE");//<-----Enter your login credential etc to access database here
						if (mysqli_connect_errno()){
							$error .= '<p class="error">Something went wrong: </p>' . mysqli_connect_error();
						}
						
						//Query to database from which to collect information
						$query = "SELECT * FROM article WHERE Users_Name = '$userinfo'";//<----Exchange query to point to correct database and row for what you want to fetch here
						$result = $connection->query($query);
						if (!$result) {
							die($connection->error);
						}
						else{
							
							//<----For each number of rows, this happens
							$rows = $result->num_rows;
							for ($j = 0 ; $j < $rows ; ++$j) {
								$result->data_seek($j);//<---Search for data
								$row = $result->fetch_array(MYSQLI_ASSOC);//<---Binding array of results to corresponding $row
								
							}
							//Terminating connection
							$result->close();
							$connection->close();
						}
					?>
					<!--Printing posts and associated data-->
					<?php
						while ($row = $result->fetch_assoc()) {
							echo '<h1>' . $row['Titel'] . '</h1>' . '<br>' . '<p>' . $row['Text'] . '</p>' . '<p><strong><em>' . $row['Users_Name'] . '</em></strong></p>' . '<p>' .$row['Category'] . '</p>' . '<br>';
						}
					?>
			</article>
			<!--Sidebar displays user profile information associated with current user in this example-->
			<aside class="sideBar">
				<div id="sideBox">
					<h1>
						<!--Print current username and bind to variable for comparison against database-->
						<?php
							echo $_SESSION["username"];
							$refname = $_SESSION["username"];
						?>
					</h1>
						<!--Fecthing current users profile picture in this example-->
						<?php
							//Include credentials to database if this is not stored in a seperate file
							$mysqli_pointer=mysqli_connect("localhost","USERNAME","PASSWORD", "DATABASE");//<-----Enter login credential etc to access database here
							if (mysqli_connect_errno()) {
								echo "Something went wrong: " . mysqli_connect_error();
							}
							$query = "SELECT `URL` FROM `pictures`";//<----Exchange query to point to correct database and row for search result here
							$result = mysqli_query($mysqli_pointer, $query) or die("Error: ".mysqli_error($mysqli_pointer));
							while($row = mysqli_fetch_array($result))//Fetching result
							{  
							$picURL = $row['URL'];//Binding to variable $picURL
							}
						?>
					<!--Display image from URL variable set through database-->
					<img src="<?php echo $picURL;?>"alt="Portrait" class="sidbild1"  width="60%">
					<p>
						<!--Fecthing current users profile information in this example-->
						<?php
							//Include credentials to database if this is not stored in a seperate file
							$mysqli_pointer=mysqli_connect("localhost","USERNAME","PASSWORD", "DATABASE");//<-----Enter login credential etc to access database here
							if (mysqli_connect_errno()) {
								echo "Something went wrong: " . mysqli_connect_error();
							}
							//Search query for user information in this example
							$query = "SELECT surname,  lastname, users_username, presentation FROM userinfo WHERE users_username = '$refname'";//<----Exchange query to point to correct database and row for search result here
							$result = mysqli_query($mysqli_pointer, $query) or die("Error: ".mysqli_error($mysqli_pointer));
							
							//While there is a result, this happens
							while($row = mysqli_fetch_array($result))
							{  
							//Print row "surname" and row "lastname" in this example
							echo $row['surname']. " ". $row['lastname'];
							}
						?>
					</p>
					<div id="sideText">
						<p>
							<!--Printing current users presentation in this example-->
							<?php
								echo $row['presentation'];
							?>
						</p>
					</div>
				</div>
			</aside>
		</div>
	</body>
</html>