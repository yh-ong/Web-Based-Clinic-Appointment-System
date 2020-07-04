<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");

$contentdata = file_get_contents("php://input");
$getdata = json_decode($contentdata);

$id = $getdata->patientID;

$query = "SELECT * FROM appointment a JOIN doctors d ON a.doctor_id = d.doctor_id JOIN speciality s ON d.doctor_speciality = s.speciality_id WHERE a.patient_id = '".$id."' ORDER BY a.app_id DESC";
$result = $conn->query($query);

if ($result->num_rows == 0) {
	echo json_encode(null);
} else {
	$arr = array();
	while ($row = mysqli_fetch_assoc($result)) {
		$arr[] = $row;
	}

	echo json_encode($arr);
	mysqli_close($conn);
}