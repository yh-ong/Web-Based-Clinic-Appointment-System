<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include("../config/database.php");
include("../config/security.php");

if(isset($_POST['inputID'])) {
	$id = mysqli_escape_string($conn,$_POST['inputID']);
	$oldpass = mysqli_escape_string($conn, $_POST['inputOldPassword']);
	$newpass = mysqli_escape_string($conn, $_POST['inputNewPassword']);
	$conpass = mysqli_escape_string($conn, $_POST['inputConPassword']);

	$checkstmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
	$checkstmt->bind_param("s", $id);
	$checkstmt->execute();
	$checkresult = $checkstmt->get_result();
	$row = $checkresult->fetch_assoc();

	$sqlpassword = $row["patient_password"];
	$token = $row["patient_token"];
	$enpass = encrypt(md5($oldpass), $token);

	if ($checkresult->num_rows != 0) {
		if ($sqlpassword == $enpass) {
			if ($newpass == $conpass) {

				$newpass = md5($newpass);
				$newtoken = generateCode(22);
				$en_pass = encrypt($newpass, $newtoken);

				$passstmt = $conn->prepare("UPDATE patients SET patient_password = ?, patient_token = ? WHERE patient_id = ? ");
				$passstmt->bind_param("sss", $en_pass, $newtoken, $id);
				if ($passstmt->execute()) {
					$result2 = $conn->query("SELECT * FROM patients WHERE patient_id = '".$id."' ");
					$numrows = mysqli_num_rows($result2);
					
					if ($numrows > 0) {
						$arr = array();
						while ($row2 = mysqli_fetch_assoc($result2)) {
							$arr[] = $row2;
						}
						echo json_encode($arr);
					} else {
						echo json_encode(null);
					}
				}
			} else {
				echo json_encode(array("1"), JSON_FORCE_OBJECT); // new & confirm not match
			}
		} else {
			echo json_encode(array("0"), JSON_FORCE_OBJECT); // password not match
		}
	} else {
		echo json_encode(array("error"), JSON_FORCE_OBJECT);
	}




	// $patient_password = decrypt($_POST['inputPassword'], $token);
	
	// $pass = mysqli_escape_string($conn,md5($_POST['inputPassword']));
	


	// if (mysqli_query($conn, $query)) {
	// 	$result2 = $conn->query("SELECT * FROM patients WHERE patient_id = '".$id."' ");
	// 	$numrows = mysqli_num_rows($result2);

	// 	if ($numrows > 0) {
	// 		$arr = array();
	// 		while ($row = mysqli_fetch_assoc($result2)) {
	// 			$arr[] = $row;
	// 		}
	// 		echo json_encode($arr);
	// 	} else {
	// 		echo json_encode(null);
	// 	}
	// } else {
	// 	echo json_encode(array("message" => "Unsuccessful."));
	// }

} else {
	echo "No Data Posted";
}

mysqli_close($conn);