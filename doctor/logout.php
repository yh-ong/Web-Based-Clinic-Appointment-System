<?php
    // session_start();
    session_unset($_SESSION['DoctorRoleID']);
    session_unset($_SESSION['DoctorRoleEmail']);
    session_unset($_SESSION['DoctorRoleLoggedIn']);
    // session_destroy();
    header("Location: login.php");
?>