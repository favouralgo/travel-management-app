<?php
    //host
    define("DB_SERVER","localhost");

    //username
    define("DB_USERNAME","root");

    //password
    define("DB_PASSWORD","");

    //databasename
    define("DB_NAME","wooxtravel");

    

    $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }
   

?>