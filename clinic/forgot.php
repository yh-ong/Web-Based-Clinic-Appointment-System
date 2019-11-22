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
                <p>Forgot Password</p>
            </div>
            <div class="login-body">
                <form name="forgot_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="inputEmailAddress">Email address</label>
                        <input type="email" name="inputEmailAddress" class="form-control" id="inputEmailAddress" aria-describedby="emailHelp" placeholder="example@email.com">
                        <small id="emailHelp" class="form-text text-muted">Provide us the email id/ mobile of your Clinic ME account<br> We will send you an email with instructions to reset your password.</small>
                    </div>
                    <button type="submit" name="forgotbtn" class="btn btn-primary btn-block button">Send Me</button>
                </form>
            </div>
            <div class="login-footer">
                <p class="text-muted"><a href="login.php"><i class="fa fa-long-arrow-alt-left"></i> Back</a></p>
            </div>
        </div>
    </div>
    <?php include JS_PATH; ?>
</body>

</html>
<?php
if (isset($_POST["forgotbtn"])) {
    $email = mysqli_real_escape_string($conn, $_POST["inputEmailAddress"]);
    $query = "SELECT * FROM clinic_manager WHERE clinicadmin_email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) != 1) {
        echo "<script>Swal.fire('Oops...','Email Not Exits','error')</script>";
    } else {
        $r = mysqli_fetch_assoc($result);
        $password = $r['clinicadmin_password'];
        // $to = $r['clinicadmin_email'];
        $to = "ongyh97@gmail.com";
        $subject = "Your Recovered Password";

        $message  = '<html><body style="font-family:Arial, Helvetica, sans-serif;padding:10px 20px;"><div align="center">';
        $message .= '<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#fcfcfc"><tbody><tr>';
        $message .= '<td style="border-left:1px solid #ddd;border-right:1px solid #ddd">';
        $message .= '<table width="100%" bgcolor="#f4f6f6" style="border-top:1px solid #ddd;"><tr>';
        $message .= '<td style="height:80px" bgcolor="#f4f6f6"></td><td>';
        $message .= '<div style="font-size:2em;text-align:center;font-weight:600;"><span style="color: #6F42C2;">US</span>.com</div>';
        $message .= '</td></tr></table>';
        $message .= '<table cellpadding="0" cellspacing="0" border="0" width="500" align="center" style="margin:25px 50px 25px 50px">';
        $message .= '<tbody><tr><td>';
        $message .= '<p style="font-size:16px;line-height:24px;color:#3c424f">' . $r["clinicadmin_name"] . ',</p>';
        $message .= "<p style='font-size:16px;line-height:24px;color:#3c424f'>We've received a request to reset your password. If you didn't make the request,just ignore this email. Otherwise, you can reset your password using this link:</p><br>";
        $message .= '<p style="margin:0" align="middle">';
        $message .= '<a href="http://localhost/hotel/hotel_frontend/forgot.php?bid=' . $r["clinicadmin_id"] . '" style="background-color:#6F42C2;color:#fff;display:inline-block;padding:0 40px;margin:0;border-radius:4px;font-size:16px;line-height:48px;text-align:center;text-decoration:none;vertical-align:center" target="_blank">Reset your Password</a>';
        $message .= '</p><br><p style="font-size:16px;line-height:24px;color:#3c424f">Thanks,<br><strong>The Clinic Team</strong></p>';
        $message .= '</td></tr></tbody></table>';
        $message .= '<table width="100%" bgcolor="#f4f6f6" cellpadding="0" cellspacing="0" border="0">';
        $message .= '<table width="100%" bgcolor="#f4f6f6" style="border-bottom:1px solid #ddd;">';
        $message .= '<tr><td style="height:80px" bgcolor="#f4f6f6"></td><td>';
        $message .= '<div style="font-size:1em;text-align:center;font-weight:600;"><span style="color: #6F42C2;">US </span>.com</div>';
        $message .= '<div style="font-size:0.9em;text-align:center;color:#aaa;">&copy; US Teams</div>';
        $message .= '</td></tr></table></table></td></tr></tbody></table></div></body></html>';

        $headers = 'From: ushotel97@gmail.com' . "\r\n" . 'Reply-To: ongyh97@gmail.com';
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo "<script>Swal.fire('Great !','Your Password Has Been Sent to Your Email','success')</script>";
        } else {
            echo "<script>Swal.fire('Oops...','Failed to Recover Your Password! Try Again!','error')</script>";
        }
    }
}
?>