<?php
include("../config/autoload.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $email = escape_input($_POST['inputEmail']);
    $password = escape_input($_POST['inputPassword']);

    $stmt = $conn->prepare("INSERT INTO patients (patient_email, patient_password, date_created) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $password, $date_created);
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="">
        <label for="">Email</label>
        <input type="text" name="inputEmail">
        
        <label for="">Password</label>
        <input type="text" name="inputPassword">

        <button type="submit" name="registerbtn">Submit</button>
    </form>
</body>
</html>