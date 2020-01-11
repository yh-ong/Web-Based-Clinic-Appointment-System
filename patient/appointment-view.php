<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");

$contentdata = file_get_contents("php://input");
$getdata = json_decode($contentdata);

$id = $getdata->appointmentID;

$query = "SELECT * FROM appointment a JOIN doctors d ON a.doctor_id = d.doctor_id JOIN clinics c ON a.clinic_id = c.clinic_id WHERE a.app_id = '".$id."' ";
$result = $conn->query($query);

if ($result->num_rows == 0) {
	echo json_encode(array("No Appointment Found"));
} else {
	$arr = array();
	while ($row = mysqli_fetch_assoc($result)) {
		// $now = Date('Y-m-d');
		// $future = strtotime($row['app_date']);
		// $timeleft = $future-strtotime($now);
		// $daysleft = round((($timeleft/24)/60)/60);

		// $datearr = array("dayleft"=> $daysleft);

		$arr[] = $row;
	}

	// $marr = array_merge($arr,$datearr);
	echo json_encode($arr);
	mysqli_close($conn);
}