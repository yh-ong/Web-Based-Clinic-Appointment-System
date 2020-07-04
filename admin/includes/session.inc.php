<?php
try {
    if ($_SESSION["admin_loggedin"] != 1)
    header("Location: login.php");

    $sess_id = $_SESSION["sess_adminid"];
    $adminstmt = $conn->prepare("SELECT * FROM admin WHERE admin_id = ?");
    $adminstmt->bind_param("i", $sess_id);
    $adminstmt->execute();
    $admin_result = $adminstmt->get_result();
    $admin_row = $admin_result->fetch_assoc();
    
    $clinic_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM clinics"));
    $patient_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM patients"));
    $appointment_count = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointment"));
    
    $adminstmt->close();
} catch (Exception $e) {
    error_log($e);
    exit('Error message for user to understand');
}