<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "college_db";
#create a database connection
$link = new mysqli($host, $user, $password, $database);
#check if the connection was successful
if ($link->connect_error) 
{
    die("Connection failed: " . $link->connect_error);
}
?>