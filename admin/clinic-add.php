<?php
require_once('../config/autoload.php');
include('includes/path.inc.php');
include('includes/session.inc.php');
include(SELECT_HELPER);
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
		<?php
			$errName = $errContact = $errEmail = $errURL  = $errAddress = $errCity = $errState = $errZipcode = "";
			$className = $classContact = $classEmail = $classURL = $classAddress = $classCity = $classState = $classZipcode = "";
			
			if (isset($_POST["savebtn"])) {
				$clinic_name = escape_input($_POST["inputClinicName"]);
				$contact = escape_input($_POST["inputContact"]);
				$email = escape_input($_POST["inputEmailAddress"]);
				$url = escape_input($_POST["inputURL"]);
			
				$opensweek = escape_input($_POST["inputOpensHourWeek"]);
				$closeweek = escape_input($_POST["inputCloseHourWeek"]);
			
				$openssat = escape_input($_POST["inputOpensHourSat"]);
				$closesat = escape_input($_POST["inputCloseHourSat"]);
			
				$openssun = escape_input($_POST["inputOpensHourSun"]);
				$closesun = escape_input($_POST["inputCloseHourSun"]);
			
				$address = escape_input($_POST["inputAddress"]);
				$city = escape_input($_POST["inputCity"]);
				if (isset($_POST['inputState'])) {
					$state = escape_input($_POST['inputState']);
				}
				$zipcode = escape_input($_POST["inputZipCode"]);
			
				// Validate
				if (empty($clinic_name)) {
					$errName = $error_html['errFirstName'];
					$className = $error_html['errClass'];
				} else {
					if (!preg_match($regrex['text'], $clinic_name)) {
						$errName = $error_html['invalidText'];
						$className = $error_html['errClass'];
					}
				}
			
				if (empty($url)) {
					$errURL = $error_html['errURL'];
					$classURL = $error_html['errClass'];
				} else {
					if (!filter_var($url, FILTER_VALIDATE_URL)) {
						$errURL =  $error_html['invalidURL'];
						$classURL = $error_html['errClass'];
					}
				}
			
				if (empty($email)) {
					$errEmail = $error_html['errEmail'];
					$classEmail = $error_html['errClass'];
				} else {
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$errEmail =  $error_html['invalidEmail'];
						$classEmail = $error_html['errClass'];
					}
				}
			
				if (empty($contact)) {
					$errContact = $error_html['errContact'];
					$classContact = $error_html['errClass'];
				} else {
					if (!preg_match($regrex['contact'], $contact)) {
						$errContact = $error_html['invalidContact'];
						$classContact = $error_html['errClass'];
					}
				}
			
				if (empty($address)) {
					$errAddress = $error_html['errAddress'];
					$classAddress = $error_html['errClass'];
				} else {
					if (!preg_match($regrex['text'], $address)) {
						$errAddress = $error_html['invalidText'];
						$classAddress = $error_html['errClass'];
					}
				}
			
				if (empty($city)) {
					$errCity = $error_html['errCity'];
					$classCity = $error_html['errClass'];
				} else {
					if (!preg_match($regrex['text'], $city)) {
						$errCity = $error_html['invalidText'];
						$classCity = $error_html['errClass'];
					}
				}
			
				if (empty($zipcode)) {
					$errZipcode = $error_html['errZipcode'];
					$classZipcode = $error_html['errClass'];
				} else {
					if (!filter_var($zipcode, FILTER_VALIDATE_INT)) {
						$errZipcode = $error_html['invalidInt'];
						$errZipcode = $error_html['errClass'];
					}
				}
			
				if (empty($state)) {
					$errState = $error_html['errState'];
					$classState = $error_html['errClass'];
				}
			
				if (multi_empty($errName, $errContact, $errURL, $errEmail, $errAddress, $errCity, $errState, $errZipcode)) {
					$clinicstmt = $conn->prepare("INSERT INTO clinics (clinic_name, clinic_email, clinic_url, clinic_contact, clinic_address, clinic_city, clinic_state, clinic_zipcode) VALUES (?,?,?,?,?,?,?,?) ");
					$clinicstmt->bind_param("ssssssss", $clinic_name, $email, $url, $contact, $address, $city, $state, $zipcode);

					if ($clinicstmt->execute()) {
                        if ($hourstmt->execute()) {
                            $last_id = mysqli_insert_id($conn);
                            $hourstmt = $conn->prepare("INSERT INTO business_hour (open_week, close_week, open_sat, close_sat, open_sun, close_sun, clinic_id) VALUES (?,?,?,?,?,?,?)");
                            $hourstmt->bind_param("sssssss", $opensweek, $closeweek, $openssat, $closesat, $openssun, $closesun, $last_id);
                            echo '<script>
                                Swal.fire({ title: "Great!", text: "Record Updated!", type: "success" }).then((result) => {
                                    if (result.value) { window.location.href = "clinic-list.php"; }
                                });
                            </script>';
                        } else {
                            echo '<script>Swal.fire({ title: "Oops...!", text: "Business Hour Error!", type: "error" });</script>';
                        }
					} else {
						echo '<script>Swal.fire({ title: "Oops...!", text: "Something Happen!", type: "error" });</script>';
					}
				}
			}
		?>
		<!-- Page content -->
		<div class="row">
			<div class="col-12">
				<form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<h5 class="card-title mt-3">
						Clinic Profile Info
					</h5>
					<div class="card">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputClinicName">Clinic Name</label>
									<input type="text" name="inputClinicName" class="form-control <?= $className ?>" id="inputClinicName" placeholder="">
									<?= $errName; ?>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputContact">Contact Number</label>
									<input type="text" name="inputContact" class="form-control <?= $classContact ?>" id="inputContact" placeholder="">
									<?= $errContact; ?>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmailAddress">Email Address</label>
									<input type="text" name="inputEmailAddress" class="form-control <?= $classEmail ?>" id="inputEmailAddress" placeholder="example@address.com">
									<?= $errEmail; ?>
								</div>
								<div class="form-group col-md-6">
									<label for="inputURL">URL</label>
									<input type="text" name="inputURL" class="form-control <?= $classURL ?>" id="inputURL" placeholder="www.example.com">
									<?= $errURL; ?>
								</div>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-body">
							<span class="card-title">Business Hour</span>
							<div class="mb-2">
								<small class="text-muted">When you're closed on a certain day, just leave the hours blank.</small>
								<small class="text-muted">Remember: 12PM is midday, 12AM is midnight</small>
							</div>
							<div class="form-group row">
								<label for="inputBusinessHourWeek" class="col-sm-2 col-form-label">Monday - Friday</label>
								<div class="col-sm-3">
									<input type="text" class="form-control form-control timepicker" name="inputOpensHourWeek">
								</div><span>--</span>
								<div class="col-sm-3">
									<input type="text" class="form-control form-control timepicker" name="inputCloseHourWeek">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputBusinessHourSat" class="col-sm-2 col-form-label">Saturday</label>
								<div class="col-sm-3">
									<input type="text" class="form-control form-control timepicker" name="inputOpensHourSat">
								</div><span>--</span>
								<div class="col-sm-3">
									<input type="text" class="form-control form-control timepicker" name="inputCloseHourSat">
								</div>
							</div>

							<div class="form-group row">
								<label for="inputBusinessHourSun" class="col-sm-2 col-form-label">Sunday</label>
								<div class="col-sm-3">
									<input type="text" class="form-control form-control timepicker" name="inputOpensHourSun">
								</div><span>--</span>
								<div class="col-sm-3">
									<input type="text" class="form-control form-control timepicker" name="inputCloseHourSun">
								</div>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<label for="inputAddress">Address</label>
								<input type="text" name="inputAddress" class="form-control <?= $classAddress ?>" id="inputAddress" placeholder="1234 Main St">
								<?= $errAddress; ?>
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputCity">City</label>
									<input type="text" name="inputCity" class="form-control <?= $classCity ?>" id="inputCity">
									<?= $errCity; ?>
								</div>
								<div class="form-group col-md-4">
									<label for="inputState">State</label>
									<select name="inputState" id="inputState" class="form-control selectpicker <?= $classState ?>" data-live-search="true">
										<option value="" selected disabled>Choose</option>
										<?php foreach ($select_state as $state_value) {
											echo '<option value="' . $state_value . '">' . $state_value . '</option>';
										} ?>
									</select>
									<?= $errState; ?>
								</div>
								<div class="form-group col-md-2">
									<label for="inputZipCode">Zip Code</label>
									<input type="text" name="inputZipCode" class="form-control <?= $classZipcode ?>" id="inputZipCode">
									<?= $errZipcode; ?>
								</div>
							</div>
						</div>
					</div>

					<div class="mb-3 mt-3">
						<button type="submit" class="btn btn-primary btn-block" name="savebtn">Save</button>
					</div>
				</form>
			</div>

		</div>
		<!-- End Page Content -->
	</div>
	<?php include JS_PATH; ?>
	<script>
		$(function() {
			$('.timepicker').datetimepicker({
				format: 'LT'
			});
		});
	</script>
</body>

</html>