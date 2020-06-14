<?php
$dbServer="localhost";
$dbUser="root";
$dbPass="";
$dbName="user_rhp_php";
$db=mysqli_connect($dbServer,$dbUser,$dbPass,$dbName);
function dedirec_to($location){
    header("location:".$location);
    exit;
}
session_start();
?>