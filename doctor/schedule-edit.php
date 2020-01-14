<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');

$id = $_GET['scheduleid'];
$schedulestmt = $conn->prepare("SELECT * FROM schedule WHERE schedule_id = ?");
$schedulestmt->bind_param("i", $id);
$schedulestmt->execute();
$result = $schedulestmt->get_result();
$row = $result->fetch_assoc();
$schedulestmt->close();

$errDoctor = $errDay = $errFrom = $errUntil = $errMin = $errStatus = "";
$classDoctor = $classDay = $classFrom = $classUntil = $classMin = $classStatus = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$doctor = escape_input($_POST['inputDoctor']);
	$day = $_POST['inputDay'];
	$from = escape_input($_POST['inputTimeFrom']);
	$until = escape_input($_POST['inputTimeTo']);
	$min = escape_input($_POST['inputMinute']);
	$status = escape_input($_POST['inputStatus']);

	if (empty($doctor)) {
		$errDoctor = $error_html['errField'];
		$classDoctor = $error_html['errClass'];
	} else {
		if (!preg_match($regrex['text'], $doctor)) {
			$errDoctor = $error_html['invalidText'];
			$classDoctor = $error_html['errClass'];
		}
	}

	// if (empty($day)) {
	// 	$errDay = $error_html['errField'];
	// 	$classDay = $error_html['errClass'];
	// }

	if (empty($from)) {
		$errFrom = $error_html['errField'];
		$classFrom = $error_html['errClass'];
	}
	
	if (empty($until)) {
		$errUntil = $error_html['errField'];
		$classUntil = $error_html['errClass'];
	}

	if (empty($min)) {
		$errMin = $error_html['errField'];
		$classMin = $error_html['errClass'];
	} else {
		if (!filter_var($min, FILTER_VALIDATE_INT)) {
			$errMin = $error_html['invalidInt'];
			$classMin = $error_html['errClass'];
		}
	}

	if ($status == "") {
		$errStatus = $error_html['errField'];
		$classStatus = $error_html['errClass'];
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
						<form name="scheduleedit_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">
							<div class="form-group row">
								<label for="inputDoctor" class="col-sm-3 col-form-label text-right">Select Dortor</label>
								<div class="col-sm-6">
									<input type="text" id="inputDoctor" name="inputDoctor" class="form-control form-control-sm <?= $classDoctor ?>" value="<?php echo $doctor_row["doctor_lastname"].' '.$doctor_row["doctor_firstname"]; ?>" readonly>
									<?php echo $errDoctor; ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputDay" class="col-sm-3 col-form-label text-right">Select Day</label>
								<div class="col-sm-6">
									<select name="inputDay" class="form-control form-control-sm <?= $classDay ?>" id="inputDay">
										<?php $inputday = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");
										foreach($inputday as $week) : ?>
											<option value="<?= $week ?>" <?= $row['week'] == $week ? 'selected' : '' ?>><?= $week ?></option>
										<?php endforeach ?>
									</select>
									<?php echo $errDay; ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputTime" class="col-sm-3 col-form-label text-right">Set Time Range</label>
								<div class="col-sm-6 input-group">
									<input type="text" name="inputTimeFrom" class="form-control form-control-sm timepicker <?= $classFrom ?>" id="inputTimeFrom" placeholder="From" value="<?= $row['start_time'] ?>">
									<input type="text" name="inputTimeTo" class="form-control form-control-sm timepicker <?= $classUntil ?>" id="inputTimeTo" placeholder="To" value="<?= $row['end_time'] ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputMinute" class="col-sm-3 col-form-label text-right">Set Duration</label>
								<div class="col-sm-6">
									<input type="text" name="inputMinute" class="form-control form-control-sm <?= $classMin ?>" id="dateto" value="<?= $row['duration'] ?>">
									<small class="form-text text-muted">You can set only minute</small>
									<?php echo $errMin; ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputStatus" class="col-sm-3 col-form-label text-right">Status</label>
								<div class="col-sm-6">
									<select name="inputStatus" class="form-control form-control-sm <?= $classStatus ?>" id="inputStatus">
										<option value="1" <?= $row['status'] == 1 ? 'selected' : "" ?>>Active</option>
										<option value="0" <?= $row['status'] == 0 ? 'selected' : "" ?>>Inactive</option>
									</select>
									<?php echo $errStatus; ?>
								</div>
							</div>
							<div class="d-flex justify-content-md-center pt-3">
								<button type="submit" class="btn btn-primary btn-sm px-5" name="savebtn">Save Changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Content -->
	</div>
	<?php include JS_PATH; ?>
	<script type="text/javascript">
		$(function () {
			$('.timepicker').datetimepicker({
				format: 'LT'
			});
		});
	</script>
</body>

</html>
<?php
if (isset($_POST['savebtn'])) {
	if (multi_empty($errDoctor, $errDay, $errFrom, $errUntil, $errMin, $errStatus)) {
		$stmt = $conn->prepare("UPDATE schedule SET week = ?, start_time = ?, end_time = ?, duration = ?, status = ? WHERE schedule_id = ?");
		$stmt->bind_param("ssssss", $day, $from, $until, $min, $status, $id);
		if ($stmt->execute()) {
			echo '<script>
				Swal.fire({ title: "Great!", text: "New Record Added!", type: "success" }).then((result) => {
					if (result.value) { window.location.href = "schedule-list.php"; }
				});
			</script>';
		} else {
			echo "Error: " . $query . "<br>" . mysqli_error($conn);
		}
		$stmt->close();
	}
}
