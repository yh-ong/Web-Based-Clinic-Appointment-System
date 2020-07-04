<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
include(EMAIL_HELPER);

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$email = escape_input($_POST["inputEmailAddress"]);

	$forgotstmt = $conn->prepare("SELECT * FROM doctors WHERE doctor_email = ?");
	$forgotstmt->bind_param("s", $email);
	$forgotstmt->execute();
	$result = $forgotstmt->get_result();
	$r = $result->fetch_assoc();

	$doctor_id = $r['doctor_id'];

	if (empty($email)) {
		array_push($errors, "Email Address is required");
	} else if ($result->num_rows != 1) {
		array_push($errors, "Email Not Exist");
	} else {
		email_validation($email);
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<?php include CSS_PATH; ?>
	<link rel="stylesheet" href="../assets/css/clinic/login.css">
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
					<?= display_error(); ?>
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
if (isset($_POST['forgotbtn']))
{
	if (count($errors) == 0) 
	{
		$selector = bin2hex(random_bytes(8));
		$validator = random_bytes(32);
		$link = $_SERVER["SERVER_NAME"] . "/doclab/doctor/reset.php?selector=".$selector."&validator=". bin2hex($validator);
		$expries = date("U") + 1800;

		$userEmail = $_POST["inputEmailAddress"];

		$stmt = $conn->prepare("DELETE FROM doctor_reset WHERE reset_email = ?");
		$stmt->bind_param("s", $userEmail);
		$stmt->execute();

		$hashedToken = password_hash($validator, PASSWORD_DEFAULT);

		$stmt = $conn->prepare("INSERT INTO doctor_reset (reset_email, reset_selector, reset_token, reset_expires) VALUE (?,?,?,?)");
		$stmt->bind_param("ssss", $userEmail, $selector, $hashedToken, $expries);
		$stmt->execute();

		$stmt->close();

		if (sendmail($userEmail, $mail['fg_subject'], $mail['fg_title'], $mail['fg_content'], $mail['fg_button'], $link, "")) {
			echo "<script>Swal.fire('Great !','Your Password Has Been Sent to Your Email','success')</script>";
		} else {
			echo "<script>Swal.fire('Oops...','Failed to Recover Your Password! Try Again!','error')</script>";
		}
	}
	$forgotstmt->close();
}
?>