<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include("../config/database.php");

$contentdata = file_get_contents("php://input");
$getdata = json_decode($contentdata);

$id = $getdata->clinicID;

$query = "SELECT * FROM clinic_images WHERE clinic_id = '$id' ";
$result = mysqli_query($conn, $query);

$numrow = mysqli_num_rows($result);

if($numrow > 0) {
	$arr = array();
	while($row = mysqli_fetch_assoc($result)) {
		$arr[] = $row;
	}

	echo json_encode($arr);
	mysqli_close($conn);
} else {
	echo json_encode(null);
}