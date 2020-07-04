<?php
    session_unset($_SESSION['sess_adminid']);
    session_unset($_SESSION['sess_adminemail']);
    session_unset($_SESSION['admin_loggedin']);
    // session_destroy();
    header("Location: login.php");
?>