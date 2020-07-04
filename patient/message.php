<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json; charset=UTF-8");

include("../config/database.php");

$contentdata = file_get_contents("php://input");
$getdata = json_decode($contentdata);

$id = $getdata->patientID;

$query = "SELECT ann_title, ann_content, c.date_created, clinic_name FROM announcement a, clinics c WHERE a.clinic_id = c.clinic_id ORDER BY ann_id DESC";
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