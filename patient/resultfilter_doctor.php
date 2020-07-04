<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include("../config/database.php");

$contentdata = file_get_contents("php://input");
$getdata = json_decode($contentdata);

$lowprice = $getdata->inputLowPrice;
$highprice = $getdata->inputHighPrice;
$gender = $getdata->inputGender;

$query = "SELECT * FROM doctors INNER JOIN speciality ON doctors.doctor_speciality = speciality.speciality_id WHERE doctor_gender = '".$gender."' AND consult_fee BETWEEN '".$lowprice."' AND '".$highprice."' ";

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