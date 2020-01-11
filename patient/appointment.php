<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/validator.php");

if(isset($_POST['inputDate'])) {
	$patient = escape_input($_POST['inputPatient']);
	$clinic = escape_input($_POST['inputClinic']);
	$doctor = escape_input($_POST['inputDoctor']);
	$treatment = escape_input($_POST['inputTreatment']);
	$date = escape_input($_POST['inputDate']);
	$time = escape_input($_POST['inputTime']);

	$stmt = $conn->prepare("INSERT INTO appointment (app_date, app_time, treatment_type, patient_id, doctor_id, clinic_id) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssiii", $date, $time, $treatment, $patient, $doctor, $clinic);
	$stmt->execute();
	$stmt->close();
	$conn->close();
} else {
	echo "No Data Post";
}