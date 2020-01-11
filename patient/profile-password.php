<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include("../config/database.php");

if(isset($_POST['inputID'])) {
	$id = mysqli_escape_string($conn,$_POST['inputID']);
	$pass = mysqli_escape_string($conn,$_POST['inputPassword']);

	$query = "UPDATE patients SET patient_password = '".$pass."' WHERE patient_id = '".$id."' ";

	if (mysqli_query($conn, $query)) {
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