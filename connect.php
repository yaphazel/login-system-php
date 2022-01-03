<?php
$dbhost = "localhost";
$username = "root";
$password = "";
$db = "todolist";

$con = mysqli_connect($dbhost,$username,$password,$db);

if(!$con){
    die("Unable to connect to database.");
}
?>