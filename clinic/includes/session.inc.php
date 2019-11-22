<?php
try {
    if ($_SESSION["loggedin"] != 1)
        header("Location: login.php");

    $sess_email = $_SESSION["sess_clinicadminemail"];

    $stmt1 = $conn->prepare("SELECT * FROM clinic_manager WHERE clinicadmin_email = ?");
    $stmt1->bind_param("s", $sess_email);
    $stmt1->execute();
    $result = $stmt1->get_result();
    $admin_row = $result->fetch_assoc();
    $adminid = $admin_row['clinic_id'];

    $stmt2 = $conn->prepare("SELECT * FROM clinics WHERE clinic_id = ?");
    $stmt2->bind_param("i", $adminid);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $clinic_row = $result->fetch_assoc();

    $stmt1->close();
    $stmt2->close();

} catch (Exception $e) {
    error_log($e);
    exit('Error message for user to understand');
}

/* $admin_result = mysqli_query($conn," SELECT * FROM clinic_manager WHERE clinicadmin_email = '".$sess_email."' ");
$admin_row = mysqli_fetch_assoc($admin_result);

$clinic_result = mysqli_query($conn,"SELECT * FROM clinics WHERE clinic_id = '".$admin_row['clinic_id']."' ");
$clinic_row = mysqli_fetch_assoc($clinic_result); */