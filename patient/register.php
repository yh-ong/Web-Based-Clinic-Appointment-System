<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");

if(isset($_POST)) {
	date_default_timezone_set('Asia/Kuala_Lumpur');
	$current_date = date('Y-m-d H:i:s');
	$lastname = mysqli_escape_string($conn,$_POST['inputlastname']);
	$firstname = mysqli_escape_string($conn,$_POST['inputfirstname']);
	$email = mysqli_escape_string($conn,$_POST['inputemail']);
	$pass = mysqli_escape_string($conn,$_POST['inputpassword']);

	$query = "INSERT INTO patients (patient_lastname, patient_firstname, patient_email, patient_password, date_created) VALUES ('".$lastname."','".$firstname."','".$email."', '".$pass."', '".$current_date."')";

	if (mysqli_query($conn, $query)) {
		echo json_encode(array("message" => "Member Added.")); 
	} else {
		echo json_encode(array("message" => "Unsuccessful."));
	}
} else {
	echo "No Data Posted";
}



// prepare and bind
// $stmt = $conn->prepare("INSERT INTO patients (patient_username, patient_email, patient_password) VALUES (?, ?, ?)");
// $stmt->bind_param("sss", $patient_username, $patient_email, $patient_password);

// set parameters and execute
// $stmt->execute();

// echo "New records created successfully";

// $stmt->close();
// $conn->close();
