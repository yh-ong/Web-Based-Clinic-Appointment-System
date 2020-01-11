<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include("../config/database.php");

// $contentdata = file_get_contents("php://input");
// $getdata = json_decode($contentdata);

// $email = $getdata->inputemail;
// $pass = $getdata->inputpass;

$email = $_POST['inputemail'];
$pass = $_POST['inputpass'];

$query = "SELECT * FROM patients WHERE patient_email = '$email' AND patient_password = '$pass' ";
$result = mysqli_query($conn, $query);

$numrow = mysqli_num_rows($result);

if($numrow == 1) {
	$arr = array();
	while($row = mysqli_fetch_assoc($result)) {
		$arr[] = $row;
	}

	echo json_encode($arr);
	mysqli_close($conn);
} else {
	echo json_encode(null);
}