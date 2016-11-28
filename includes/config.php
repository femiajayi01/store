<?php
    
defined('db_server') ? NULL : define('db_server', 'localhost');
defined('db_user') ? NULL : define('db_user', 'root');
defined('db_pass') ? NULL : define('db_pass', '');
defined('db_name') ? NULL : define('db_name', 'store');


    $conn = new mysqli(db_server, db_user, db_pass);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "CREATE DATABASE IF NOT EXISTS " . db_name;
    $conn->query($sql);
    $conn->close();




?>

