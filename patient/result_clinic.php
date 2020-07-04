<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include("../config/database.php");

// $query = "SELECT * FROM clinics, clinic_images, doctors WHERE clinic_images.clinic_id = clinics.clinic_id AND clinics.clinic_id = doctors.clinic_id ";
$query = "SELECT * FROM clinics WHERE clinic_status = 1";

$result = mysqli_query($conn, $query);

$numrow = mysqli_num_rows($result);

if($numrow > 0) {
	$arr = array();
	while($row = mysqli_fetch_assoc($result)) {
		$arr[] = $row;
	}

	echo json_encode($arr);
	mysqli_close($conn);
} else {
	echo json_encode(null);
}