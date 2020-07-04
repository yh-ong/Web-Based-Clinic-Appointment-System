<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");
include("../config/security.php");

if (isset($_POST['inputemail']) && isset($_POST['inputpass'])) {
	$email = mysqli_escape_string($conn, $_POST['inputemail']);
	$pass = mysqli_escape_string($conn, $_POST['inputpass']);

	$check = $conn->prepare("SELECT * FROM patients WHERE patient_email = ? ");
    $check->bind_param("s", $email);
    $check->execute();
    $q = $check->get_result();
    $r = $q->fetch_assoc();
    if (mysqli_num_rows($q) != 1) {
		echo json_encode(array("0"), JSON_FORCE_OBJECT);
	} else {
        $token = $r["patient_token"];
        $inputPassword = $conn->real_escape_string(md5($_POST['inputpass']));
		$enpass = encrypt($inputPassword, $token);

		$checkstmt = $conn->prepare("SELECT * FROM patients WHERE patient_email = ? AND patient_password = ?");
		$checkstmt->bind_param("ss", $email, $enpass);
		$checkstmt->execute();
		$checkresult = $checkstmt->get_result();
			
		if ($checkresult->num_rows > 0) {
			$arr = array();
			while($row = $checkresult->fetch_assoc()) {
				$arr[] = $row;
			}

			echo json_encode($arr);
			mysqli_close($conn);
		} else {
			echo json_encode(array("0"), JSON_FORCE_OBJECT);
		}
	}

} else {
	echo 'No Data Post';
}