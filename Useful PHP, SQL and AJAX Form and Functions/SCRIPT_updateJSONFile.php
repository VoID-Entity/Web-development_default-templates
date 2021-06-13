<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, UpdateJSON, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

//Connection to database containing data to be written to JSON file. 
$mysqli_pointer = mysqli_connect("localhost","USERNAME","PASSWORD", "DATABASE");//<-----Enter login credentials etc to access database here
if (mysqli_connect_errno()){
	$error .= '<p class="error">Something went wrong: </p>' . mysqli_connect_error();
}
//Query to database from which to collect information
$result = mysqli_query($mysqli_pointer, "SELECT type FROM category");//<----Exchange query to point to correct database and row for what you want to fetch here
$resultSet = array();//Creates array to store result
while($row = mysqli_fetch_array($result)) {//While there is another row inte the array with a result, Continue loop
	$resultSet[] = array( 'Category' => $row['Typ']);//<----Exchange row-array variables to point to correct database and row for what you want to fetch here
}
//Write content to JSON file
file_put_contents('categories.json', json_encode($resultSet));//<-----Specify name of JSON file in which to print resluts. "categories.json" is only an example 

?>