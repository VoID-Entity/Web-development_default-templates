<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, Session, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

//Starts session
session_start();

//If below variables are set during login, this happens
if(isset($_SESSION["id"]) && isset($_SESSION["username"])){
	
	//Storing variables
	$current_userid = $_SESSION["id"];
	$current_username = $_SESSION["username"];
}
//redirect if below variables are not set.
else {
	header("location: login.php");//<-----Name of page containing user login form
}
 ?>