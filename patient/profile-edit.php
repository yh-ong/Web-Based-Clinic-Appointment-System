<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include("../config/database.php");

if(isset($_POST['inputID'])) {
	$id = mysqli_escape_string($conn,$_POST['inputID']);
	$firstname = mysqli_escape_string($conn,$_POST['inputFirstname']);
	$lastname = mysqli_escape_string($conn,$_POST['inputLastname']);
	$email = mysqli_escape_string($conn,$_POST['inputEmail']);
	$identity = mysqli_escape_string($conn,$_POST['inputIdentity']);
	$dob = mysqli_escape_string($conn,$_POST['inputDOB']);
	$gender = mysqli_escape_string($conn,$_POST['inputGender']);
	$contact = mysqli_escape_string($conn,$_POST['inputContact']);
	$maritalstatus = mysqli_escape_string($conn,$_POST['inputMaritalStatus']);
	$nationality = mysqli_escape_string($conn,$_POST['inputNationality']);

	// $query = "UPDATE patients SET patient_firstname = '".$firstname."', patient_lastname = '".$lastname."', patient_identity = '".$identity."', patient_email = '".$email."', patient_dob = '".$dob."', patient_gender = '".$gender."', patient_contact = '".$contact."', patient_maritalstatus = '".$maritalstatus."', patient_nationality = '".$nationality."' WHERE patient_id = '".$id."' ";
	
	$stmt = $conn->prepare("UPDATE patients SET patient_firstname = ?, patient_lastname = ?, patient_identity = ?, patient_email = ?, patient_dob = ?, patient_gender = ?, patient_contact = ?, patient_maritalstatus = ?, patient_nationality = ? WHERE patient_id = ? ");
	$stmt->bind_param("ssssssssss", $firstname, $lastname, $identity, $email, $dob, $gender, $contact, $maritalstatus, $nationality, $id);

	if ($stmt->execute()) {
		$result2 = $conn->query("SELECT * FROM patients WHERE patient_id = '".$id."' ");
		$numrows = mysqli_num_rows($result2);

		if ($numrows > 0) {
			$arr = array();
			while ($row = mysqli_fetch_assoc($result2)) {
				$arr[] = $row;
			}
			echo json_encode($arr);
		} else {
			echo json_encode(null);
		}
	} else {
		echo json_encode(array("message" => "Unsuccessful."));
	}
} else {
	echo "No Data Posted";
}
mysqli_close($conn);