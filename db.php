<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "dental_clinic";

$conn = new mysqli("localhost", "root", "", "dental_clinic");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
