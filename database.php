<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "dalelshop";
    $conn;
    $error = '';

    
    try{
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }
    catch(mysqli_sql_exception){
        echo "Failed to connect";
    }
?>