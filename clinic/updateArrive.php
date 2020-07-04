<?php
include('../config/autoload.php');

if(isset($_POST['id']) && !empty($_POST['id']))
{
    $id = $_POST['id'];
    include('../config/database.php');

    $update = "UPDATE appointment SET arrive_status = 1 WHERE app_id = '".$id."'";

    if (mysqli_query($conn, $update))
    {
        echo "Record updated successfully";
    } 
    else 
    {
        echo "Error updating record: " . mysqli_error($conn);
    }
    die;
}