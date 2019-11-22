<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
?>
<!DOCTYPE html>
<html>

<head>
    <?php include CSS_PATH; ?>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
    <div class="container">
        <div class="login-wrap mx-auto">
            <div class="login-head">
                <h4><?php echo $BRAND_NAME; ?></h4>
                <p>Create an Account! Manage Our Feature</p>
            </div>
            <div class="login-body">
                <form name="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Clinic Name</label>
                        <input type="text" name="inputClinicName" class="form-control" id="inputClinicName" placeholder="Clinic Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputManagerName">Clinic Manager Name</label>
                        <input type="text" name="inputManagerName" class="form-control" id="inputClinicName" placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Address</label>
                        <input type="email" name="inputEmail" class="form-control" id="inputEmail" placeholder="example@address.com">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputContact">Contact Number</label>
                        <input type="text" name="inputContact" class="form-control" id="inputContact" placeholder="01012345678">
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
    <?php include JS_PATH; ?>
</body>

</html>
<?php
if (isset($_POST['registerbtn'])) {
    $name     = $conn->real_escape_string($_POST['inputClinicName']);
    $manager  = $conn->real_escape_string($_POST['inputManagerName']);
    $email    = $conn->real_escape_string($_POST['inputEmail']);
    $contact  = $conn->real_escape_string($_POST['inputContact']);
    $password = md5($conn->real_escape_string($_POST['inputPassword']));

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query2 = "INSERT INTO clinics (clinic_name, date_created ) VALUES ('" . $name . "','" . $date_created . "')";
    if (mysqli_query($conn, $query2)) {
        $last_id = mysqli_insert_id($conn);
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $query1 = "INSERT INTO clinic_manager (clinicadmin_name, clinicadmin_email, clinicadmin_password, clinicadmin_contact, date_created, clinic_id) VALUES ('" . $manager . "','" . $email . "','" . $password . "','" . $contact . "','" . $date_created . "','" . $last_id . "')";
    if (mysqli_query($conn, $query1)) {
        echo '<script>alert("Clinic Have Been Created");</script>';
        $_SESSION['sess_email'] = $email;
        $_SESSION['loggedin'] = 1;
        header("Location: clinic-register.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>