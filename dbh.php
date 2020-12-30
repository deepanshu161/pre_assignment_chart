<?php
$dbname = "chart_interview";
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";


//Connection
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()) {
    echo "Error";
    exit();
}