<?php 
    include("includes/dbconnection.php");
    session_unset();
    session_destroy();
    header("Location: login.php");
?>