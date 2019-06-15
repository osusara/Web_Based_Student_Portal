<?php

	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'student_portal';

	$connection = mysqli_connect($host, $username, $password, $database);

	if(mysqli_connect_errno()){
		die('Database connection error: '.mysqli_connect_error());
	}else{

	}

?>