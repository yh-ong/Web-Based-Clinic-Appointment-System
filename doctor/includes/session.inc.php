<?php

if ($_SESSION["DoctorRoleLoggedIn"] != 1)
    header("Location: login.php");

$sess_email = $_SESSION["DoctorRoleEmail"];

// $admin_result = mysqli_query($conn,"SELECT * FROM doctors WHERE doctor_email = '".$sess_email."' ");
// $admin_row = mysqli_fetch_assoc($admin_result);

$stmt = $conn->prepare("SELECT * FROM doctors WHERE doctor_email = ?");
$stmt->bind_param("s", $sess_email);
$stmt->execute();
$doctor_result = $stmt->get_result();
$doctor_row = $doctor_result->fetch_assoc();

$token = $doctor_row["doctor_token"];

$pt_row = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointment INNER JOIN patients ON appointment.patient_id = patients.patient_id WHERE doctor_id = '".$doctor_row['doctor_id']."' AND status = 1"));
$app_row = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointment WHERE doctor_id = '".$doctor_row['doctor_id']."'"));
$tr_row = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM treatment_type WHERE doctor_id = '".$doctor_row['doctor_id']."'"));