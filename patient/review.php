<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/validator.php");

if(isset($_POST['inputRating'])) {
	$patient = escape_input($_POST['inputPatientID']);
	$doctor = escape_input($_POST['inputDoctorID']);
	$rating = escape_input($_POST['inputRating']);
	$review = escape_input($_POST['inputReview']);
	$date = date('Y-m-d');

	$stmt = $conn->prepare("INSERT INTO reviews (rating, review, date, doctor_id, patient_id) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("sssii", $rating, $review, $date, $doctor, $patient);
	$stmt->execute();
	$stmt->close();
	$conn->close();
} else {
	echo "No Data Post";
}