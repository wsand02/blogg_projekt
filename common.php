<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "blogg";


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();

$logged_in = false;

if (isset($_SESSION["uid"])) {
  $logged_in = true;
}
