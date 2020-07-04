<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/security.php");
include("../config/validator.php");

if(isset($_POST['inputemail'])) {
	date_default_timezone_set('Asia/Kuala_Lumpur');
	$current_date = date('Y-m-d H:i:s');
	$lastname = escape_input($_POST['inputlastname']);
	$firstname = escape_input($_POST['inputfirstname']);
	$identity = escape_input($_POST['inputidentity']);
	$email = escape_input($_POST['inputemail']);
	$pass = escape_input(md5($_POST['inputpassword']));

	$token = generateCode(22);
	$en_pass = encrypt($pass, $token);

	$sql = "SELECT * FROM patients WHERE patient_email = '".$email."'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		$message_array = array("0");
		echo json_encode($message_array, JSON_FORCE_OBJECT);
	} else {
		$query = "INSERT INTO patients (patient_lastname, patient_firstname, patient_email, patient_password, patient_token, patient_identity, date_created) VALUES ('".$lastname."','".$firstname."','".$email."', '".$en_pass."', '".$token."', '".$identity."' ,'".$current_date."')";

		if (mysqli_query($conn, $query)) {
			$message_array = array("1");
			echo json_encode($message_array, JSON_FORCE_OBJECT);
		} else {
			$message_array = array("0");
			echo json_encode($message_array, JSON_FORCE_OBJECT);
		}
	}
} else {
	echo "No Data Posted";
}