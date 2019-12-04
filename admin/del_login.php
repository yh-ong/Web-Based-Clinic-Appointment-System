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
    <div class="container-fluid">
        <div class="row">
            <!-- Left -->
            <div class="login-wrap bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                <div class="login-box col-11 mx-auto">
                    <h4 class="mb-4 login-title">Clinic Appointment System</h4>
                    <h6 class="mb-3 login-desc">
                        <span class="d-block">Welcome back,</span>
                        <span>Please sign in to your account.</span>
                    </h6>
                    <p class="mb-3">No account? <a href="register.php" class="text-primary">Sign up now</a></p>
                    <div class="divider row"></div>

                    <form name="login_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="inputEmail" class="">Email</label>
                                    <input name="email" id="inputEmail" placeholder="Email here..." type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="inputPassword" class="">Password</label>
                                    <input name="password" id="inputPassword" placeholder="Password here..." type="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="position-relative form-check">
                            <input name="check" id="exampleCheck" type="checkbox" class="form-check-input">
                            <label for="exampleCheck" class="form-check-label">Keep me logged in</label>
                        </div> -->
                        <div class="divider row"></div>
                        <div class="d-flex align-items-center">
                            <div class="ml-auto">
                                <a href="#" class="btn btn-link">Recover Password</a>
                                <button type="submit" name="submit_login" class="btn btn-primary">Login to Dashboard</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Left Wrap -->
            <!-- Right -->
            <div class="p-0 col-lg-4">
                <div class="bg-login"></div>
            </div>
            <!-- End Right Wrap -->
        </div>
    </div>
    <?php include 'includes/footer.php';?>
</body>
</html>
<?php
if(isset($_POST['submit_login']))
{
    $inputEmail = $conn->real_escape_string($_POST['email']);
    $inputPassword = $conn->real_escape_string($_POST['password']);
    
    $sql = "SELECT * FROM admin WHERE admin_email = '".$inputEmail."' AND admin_pass = '".$inputPassword."'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$result = $conn->query($sql)) {
        die('There was an error running the query [' . $conn->error . ']');
    }

    if ($inputEmail == "" && empty($inputEmail)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Email', type: 'error'}).then(function() { $('#inputEmail').focus(); });</script>";
        exit();
    }

    if ($inputPassword == "" && empty($inputPassword)) {
        echo "<script>Swal.fire({title: 'Error!', text: 'Please Enter a Password', type: 'error'}).then(function() { $('#inputPassword').focus(); });</script>";
        exit();
    }
    
    if (mysqli_num_rows($result) != 1)
    {
        echo "<script>Swal.fire({title: 'Error!', text: 'Email & Password Not Exist', type: 'error', confirmButtonText: 'Try Again'})</script>";
        exit();
    } 
    else 
    {
        $_SESSION['sess_adminid'] = $row['admin_id'];
        $_SESSION['loggedin'] = 1;
        header("Location: index.php");
        ob_end_flush();
    }
    mysqli_close($conn);
}
?>