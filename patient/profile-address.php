<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include("../config/database.php");

if(isset($_POST['inputID'])) {
	$id = mysqli_escape_string($conn,$_POST['inputID']);
	$address = mysqli_escape_string($conn,$_POST['inputAddress']);
	$city = mysqli_escape_string($conn,$_POST['inputCity']);
	$state = mysqli_escape_string($conn,$_POST['inputState']);
	$zipcode = mysqli_escape_string($conn,$_POST['inputZipcode']);
	$country = mysqli_escape_string($conn,$_POST['inputCountry']);

	// $query = "UPDATE patients SET patient_address = '".$address."', patient_city = '".$city."', patient_state = '".$state."', patient_zipcode = '".$zipcode."' WHERE patient_id = '".$id."' ";
	$stmt = $conn->prepare("UPDATE patients SET patient_address = ?, patient_city = ?, patient_state = ?, patient_zipcode = ?, patient_country = ? WHERE patient_id = ? ");
	$stmt->bind_param("ssssss", $address, $city, $state, $zipcode, $country, $id);

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