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

//Connect to the database containing the information you want to update
$mysqli_pointer = mysqli_connect("localhost","USERNAME","PASSWORD", "DATABASE");//<-----Here you enter your login credentials etc to access database
if (mysqli_connect_errno()){
	$error .= '<p class="error">Something went wrong: </p>' . mysqli_connect_error();
}
//Query to database from which to collect information
$result = mysqli_query($mysqli_pointer, "SELECT type FROM category");//<----Here you exchange query to point to correct database and row for what you want to fetch
$resultSet = array();//Creates array to store result
while($row = mysqli_fetch_array($result)) {//While there is another row inte the array with a result, Continue loop
	$resultSet[] = array( 'Category' => $row['Typ']);//<----Here you exchange row-array variables to point to correct database and row for what you want to fetch
}
//Write content to JSON file
file_put_contents('categories.json', json_encode($resultSet));//<-----Here you need to specify which file you want to write resluts to, "categories.json" is just an example

?>