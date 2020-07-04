<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/validator.php");
include("../helper/email.helper.php");

if(isset($_POST['inputDate'])) {
	$patient = escape_input($_POST['inputPatient']);
	$clinic = escape_input($_POST['inputClinic']);
	$doctor = escape_input($_POST['inputDoctor']);
	$treatment = escape_input($_POST['inputTreatment']);
	$date = escape_input($_POST['inputDate']);
	$time = escape_input($_POST['inputTime']);
	$patient_name = escape_input($_POST['inputPatientName']);
	$doctor_name = escape_input($_POST['inputDoctorName']);

	$email = escape_input($_POST['inputEmail']);

	$status = 1;
	$consult = 0;
	$arrive = 0;

	$stmt = $conn->prepare("INSERT INTO appointment (app_date, app_time, treatment_type, patient_id, doctor_id, clinic_id, status, consult_status, arrive_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("sssiiiiii", $date, $time, $treatment, $patient, $doctor, $clinic, $status, $consult, $arrive);
	
	if ($stmt->execute()) {
		$content = "Hi ".$patient_name.", <br> You have make a appointment with ".$doctor_name." on (".$date.") at (".$time.").";
		sendmail($email, $mail['con_subject'], $mail['con_title'], $content, "", "", "");
	}

	$stmt->close();
	$conn->close();
} else {
	echo "No Data Post";
}