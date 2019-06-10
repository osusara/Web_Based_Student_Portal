<?php

    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'test_program';

    $connection = mysqli_connect($host, $username, $password, $database);

    if(mysqli_connect_errno()){
        die('Connection Error: '.mysqli_connect_error);
    }else{
        
    }

?>