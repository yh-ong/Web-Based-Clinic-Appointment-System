<?php
try {
    if ($_SESSION["loggedin"] != 1) {
        header("Location: login.php");
    }

    $sess_email = $_SESSION["sess_clinicadminemail"];

    $stmt1 = $conn->prepare("SELECT * FROM clinic_manager WHERE clinicadmin_email = ?");
    $stmt1->bind_param("s", $sess_email);
    $stmt1->execute();
    // $result = $stmt1->get_result();
    $admin_row = $stmt1->get_result()->fetch_assoc();
    $adminid = $admin_row['clinic_id'];
    $token = $admin_row["clinicadmin_token"];

    $stmt2 = $conn->prepare("SELECT * FROM clinics WHERE clinic_id = ?");
    $stmt2->bind_param("i", $adminid);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $clinic_row = $result->fetch_assoc();

    $pt_row = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointment INNER JOIN patients ON appointment.patient_id = patients.patient_id WHERE appointment.clinic_id = '".$clinic_row['clinic_id']."' AND appointment.status = 1"));
    $app_row = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM appointment WHERE clinic_id = '".$clinic_row['clinic_id']."'"));
    $tr_row = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM doctors WHERE clinic_id = '".$clinic_row['clinic_id']."'"));

    $stmt1->close();
    $stmt2->close();

} catch (Exception $e) {
    error_log($e);
    exit('Error message for user to understand');
}