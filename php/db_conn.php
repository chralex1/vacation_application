<?php 

$host = "localhost";
$uname = "root";
$pwd = "";
$dbname = "epignosis";

$conn = mysqli_connect($host, $uname, $pwd, $dbname);

if(!$conn) {
    echo "Connection Failed";
    exit();
}