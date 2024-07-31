<?php
    //Defined host
    define("DB_SERVER","51.20.181.20");

    //Defined username
    define("DB_USERNAME","root");

    //No password
    define("DB_PASSWORD","");

    //Defined databasename
    define("DB_NAME","wooxtravel");

    
    // Make connection
    $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    }
   

?>