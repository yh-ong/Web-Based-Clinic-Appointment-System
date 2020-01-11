<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/validator.php");

if(isset($_POST['inputAppointmentID'])) {
	$app_id = escape_input($_POST['inputAppointmentID']);

	$stmt = $conn->prepare("UPDATE appointment SET status = 1 WHERE app_id = ? ");
	$stmt->bind_param("s", $app_id);
	$stmt->execute();
	$stmt->close();
	$conn->close();
} else {
	echo json_encode("No Data Post");
}