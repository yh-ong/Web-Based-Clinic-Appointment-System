<?php

if ($_SESSION["loggedin"] != 1)
    header("Location: login.php");

$sess_email = $_SESSION["sess_email"];
$admin_result = mysqli_query($conn,"SELECT * FROM doctors WHERE doctor_email = '".$sess_email."' ");
$admin_row = mysqli_fetch_assoc($admin_result);

$doctor_result = mysqli_query($conn,"SELECT * FROM doctors WHERE doctor_id = '".$admin_row['doctor_id']."' ");
$doctor_row = mysqli_fetch_assoc($doctor_result);

$pt_row = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointment INNER JOIN patients ON appointment.patient_id = patients.patient_id WHERE doctor_id = '".$admin_row['doctor_id']."' AND status = 1"));
$app_row = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointment WHERE doctor_id = '".$admin_row['doctor_id']."'"));