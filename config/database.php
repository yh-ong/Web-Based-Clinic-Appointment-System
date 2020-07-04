<?php
session_start();

$hostname = "localhost";
$username = "root";
$password = "";
$database = "clinic_appointment";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
	$conn = new mysqli($hostname, $username, $password, $database);
	$conn->set_charset("utf8mb4");
} catch (Exception $e) {
	error_log($e->getMessage());
	exit('Error connecting to database');
}
