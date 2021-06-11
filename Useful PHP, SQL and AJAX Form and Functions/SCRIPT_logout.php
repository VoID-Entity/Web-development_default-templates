<?php

//--------------------------------------------------------------------------------------------------------------------
//
//Theme Name: Default Template
//Author: Patrik Nilsson
//Description: PHP Template
//Version: 1.0
//License: GNU General Public License v2 or later
//Tags: PHP Template, LogoutScript, SQL Examples
//Text Domain: https://github.com/VoID-Entity
//
//--------------------------------------------------------------------------------------------------------------------

session_start();

//Kill session
if(session_destroy()) {
	
	//Destroy _SESSION variables.
	unset($_SESSION["id"]);
	unset($_SESSION["username"]);
	
	//Redirect to login.php
	header("location: login.php");//<---Change to whatever page you want a logout to redrect to
	exit;
}
?>