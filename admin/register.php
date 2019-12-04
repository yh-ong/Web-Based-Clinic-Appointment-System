<?php
require_once("includes/dbconnection.php");
include("includes/config.php");
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'includes/styles.php';?>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <div class="container">
        <div class="login-wrap mx-auto">
            <div class="login-head">
                <h4><?php echo $BRAND_NAME;?></h4>
                <p>Create an Account! Manage Our Feature</p>
            </div>
            <div class="login-body">
                <form name="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Clinic Name</label>
                        <input type="text" name="inputClinicName" class="form-control" id="inputClinicName" placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="inputEmail" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="example@address.com">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group mb-4">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="inputPassword" class="form-control" id="inputPassword" placeholder="Enter Password">
                    </div>
                    <button type="submit" name="registerbtn" class="btn btn-primary btn-block button">Create an Account</button>
                </form>
            </div>
            <div class="login-footer">
                <p class="text-muted">Already have an account? <a href="login.php">Sign In</a></p>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php';?>
</body>

</html>
<?php
if (isset($_POST['registerbtn'])) {
    $name = $conn->real_escape_string($_POST['inputClinicName']);
    $email = $conn->real_escape_string($_POST['inputEmail']);
    $password = $conn->real_escape_string($_POST['inputPassword']);

    $sql = "SELECT * FROM clinics WHERE clinic_email = '" . $email . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$result = $conn->query($sql)) {
        die('There was an error running the query [' . $conn->error . ']');
    }

    if ($name == "" && empty($name)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Clinic Name', type: 'error'}).then(function() { $('#inputClinicName').focus(); });</script>";
        exit();
    }

    if ($email == "" && empty($email)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Email', type: 'error'}).then(function() { $('#inputEmail').focus(); });</script>";
        exit();
    }

    if ($password == "" && empty($password)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Password', type: 'error'}).then(function() { $('#inputPassword').focus(); });</script>";
        exit();
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Email Already Exist', type: 'error', confirmButtonText: 'Try Again'})</script>";
        exit();
    } else {
        $query = "INSERT INTO clinics (clinic_name, clinic_email, clinic_password) VALUES ('".$name."','".$email."','".$password."')";
        // mysqli_query($conn,$query);
        $_SESSION['sess_email'] = $email;
        $_SESSION['loggedin'] = 1;
        header("Location: clinic-register.php");
        ob_end_flush();
    }
    mysqli_close($conn);
}
?>