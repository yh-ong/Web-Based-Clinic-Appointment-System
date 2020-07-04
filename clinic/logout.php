<?php
// session_start();
session_unset($_SESSION['sess_clinicadminid']);
session_unset($_SESSION['sess_clinicadminemail']);
// session_destroy();
header("Location: login.php");