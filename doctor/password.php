<?php
require_once('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$password = decrypt($doctor_row['doctor_password'], $token);
	$old_password = escape_input($_POST['inputOldPassword']);
	$new_password = escape_input($_POST['inputNewPassword']);
	$con_password = escape_input($_POST['inputConfirmPassword']);
	
	if (empty($old_password)) {
		array_push($errors, "Password is required");
	} elseif (empty($new_password)) {
		array_push($errors, "New Password is required");
	} elseif (empty($con_password)) {
		array_push($errors, "Confirm Password is required");
	} elseif (md5($old_password) != $password) {
		array_push($errors, "Incorrect Password");
	} elseif (!empty($new_password)) {
        password_validation($new_password);
    } elseif ($new_password != $con_password) {
        array_push($errors, "Password not Equal");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include CSS_PATH; ?>
</head>

<body>
	<?php include NAVIGATION; ?>
	<div class="page-content" id="content">
		<?php include HEADER; ?>
		<!-- Page content -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form name="passform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
							<?= display_error(); ?>
							<div class="form-group row">
								<label for="inputOldPassword" class="col-sm-3 col-form-label text-right">Old Password</label>
								<div class="col-sm-6">
									<input type="text" id="inputOldPassword" name="inputOldPassword" class="form-control form-control-sm" value="">
								</div>
							</div>

							<div class="form-group row">
								<label for="inputNewPassword" class="col-sm-3 col-form-label text-right">New Password</label>
								<div class="col-sm-6">
									<input type="text" id="inputNewPassword" name="inputNewPassword" class="form-control form-control-sm" value="">
									<small class="form-text text-muted" id="passwordHelp">Use 8 or more characters with a mix of letters, numbers & symbols</small>
								</div>
							</div>

							<div class="form-group row">
								<label for="inputConfirmPassword" class="col-sm-3 col-form-label text-right">Confirm New Password</label>
								<div class="col-sm-6">
									<input type="text" id="inputConfirmPassword" name="inputConfirmPassword" class="form-control form-control-sm" value="">
								</div>
							</div>

							<div class="d-flex justify-content-md-center pt-4">
								<button type="reset" class="btn btn-light btn-sm px-5 mr-2" name="clearbtn">Clear</button>
								<button type="submit" class="btn btn-primary btn-sm px-5" name="submitbtn">Save Changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Content -->
	</div>
	<?php include JS_PATH; ?>
</body>

</html>
<?php
if (isset($_POST['submitbtn']))
{
	if (count($errors) == 0)
	{
		$en_pass = encrypt(md5($new_password), $token);

		$stmt = $conn->prepare("UPDATE doctors SET doctor_password = ? WHERE doctor_id = ?");
		$stmt->bind_param("si", $en_pass, $doctor_row['doctor_id']);
		if ($stmt->execute()) 
		{
			echo "<script>Swal.fire('Great','Password Updated!','success')</script>";
		}
	}
}
?>