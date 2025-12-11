<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "dental_clinic_bam";

$conn = new mysqli("localhost", "root", "", "dental_clinic_bam");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
