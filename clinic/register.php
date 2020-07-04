<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
ob_start();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = escape_input($_POST['inputClinicName']);
    $manager  = escape_input($_POST['inputManagerName']);
    $email    = escape_input($_POST['inputEmail']);
    $contact  = escape_input($_POST['inputContact']);
    $password = $conn->real_escape_string($_POST['inputPassword']);
    $con_pass = $conn->real_escape_string($_POST['inputConfirmPassword']);

    if (empty($name)) {
        array_push($errors, "Clinic Name is required");
    }
    if (empty($manager)) {
        array_push($errors, "Clinic Manager Name is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    } else {
        email_validation($email);
    }
    if (empty($contact)) {
        array_push($errors, "Contact is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    } elseif ($password != $con_pass) {
        array_push($errors, "Password not Equal");
    } else {
        password_validation($password);
    }

    if (empty($con_pass)) {
        array_push($errors, "Confirm Password is required");
    }
}
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
                <p>Create an Account! Manage Your Clinic</p>
            </div>
            <div class="login-body">
                <form name="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php echo display_error(); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Clinic Name</label>
                        <input type="text" name="inputClinicName" class="form-control" id="inputClinicName" placeholder="Clinic Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputManagerName">Clinic Manager Name</label>
                        <input type="text" name="inputManagerName" class="form-control" id="inputClinicName" placeholder="John Doe">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="exampleInputEmail1">Email Address</label>
                            <input type="text" name="inputEmail" class="form-control" id="inputEmail" placeholder="example@address.com">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputContact">Contact Number</label>
                            <input type="text" name="inputContact" class="form-control" id="inputContact" placeholder="01012345678">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="inputPassword" class="form-control" id="inputPassword" placeholder="Enter Password" data-toggle="popover" data-placement="left" data-content="Password must contain at least 8 characters, including UPPERCASE, lowercase and numbers">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input type="password" name="inputConfirmPassword" class="form-control" id="inputConfirmPassword" placeholder="Re-enter Password">
                        </div>
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
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
        });
    </script>
</body>

</html>
<?php
if (isset($_POST['registerbtn'])) {
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (count($errors) == 0) {
        $stmt = $conn->prepare("INSERT INTO clinics (clinic_name, date_created) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $date_created);
        if ($stmt->execute()) {
            $last_id = mysqli_insert_id($conn);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        $stmt->close();

        $token = generateCode(22);
        $en_pass = encrypt(md5($password), $token);
        
        $stmt = $conn->prepare("INSERT INTO clinic_manager (clinicadmin_name, clinicadmin_email, clinicadmin_password, clinicadmin_token, clinicadmin_contact, date_created, clinic_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $manager, $email, $en_pass, $token, $contact, $date_created, $last_id);

        $weekstmt = $conn->prepare("INSERT INTO business_hour (clinic_id) VALUES (?)");
        $weekstmt->bind_param("i", $last_id);

        if ($stmt->execute() && $weekstmt->execute()) {
            $_SESSION['sess_clinicadminemail'] = $email;
            $_SESSION['loggedin'] = 1;
            header("Location: clinic-register.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $stmt->close();
        $weekstmt->close();
    }
}
?>