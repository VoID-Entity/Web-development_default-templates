<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, DatabaseConnection, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

//Defining login credentials.
define('DBSERVER', 'localhost');//<-----Server address.
define('DBUSERNAME', 'USERNAME');//<-----Username in PHPMyAdmin or similar.
define('DBPASSWORD', 'PASSWORD');//<-----Password for user in PHPMyAdmin or similar.
define('DBNAME', 'DATABASE');//<-----The database you want to access.
	
//Binding credentials listed above to variable used for connection to database.
$mysqli_pointer = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

//If error!
if ($mysqli_pointer === false) {
	die("Error: connection error. " . mysqli_connect_error());
}
?>