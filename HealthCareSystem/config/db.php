<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "health_care_system";

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);
if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}
    