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
						<form name="report_frm" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URL"]); ?>">
							<div class="form-group row">
								<label for="inputDoctor" class="col-sm-3 col-form-label text-right">Select Dortor</label>
								<div class="col-sm-6">
									<input type="text" id="inputDoctor" class="form-control form-control-sm" value="<?php echo $doctor_row["doctor_lastname"].' '.$doctor_row["doctor_firstname"]; ?>" disabled>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputDay" class="col-sm-3 col-form-label text-right">Select Day</label>
								<div class="col-sm-6">
									<select name="inputDay" class="form-control form-control-sm" id="inputDay">
										<?php foreach(array("Monday","Tuesday","Wednesday","Thurday","Friday","Saturday","Sunday") as $day) : ?>
											<option value="<?= $day ?>" <?= $row['day'] == $day ? 'selected' : '' ?>><?= $day ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputTime" class="col-sm-3 col-form-label text-right">Set Time Range</label>
								<div class="col-sm-6 input-group">
									<input type="text" name="inputTimeFrom" class="form-control form-control-sm timepicker" id="inputTimeFrom" placeholder="From" value="<?= $row['start_time'] ?>">
									<input type="text" name="inputTimeTo" class="form-control form-control-sm timepicker" id="inputTimeTo" placeholder="To" value="<?= $row['end_time'] ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputMinute" class="col-sm-3 col-form-label text-right">Set Duration</label>
								<div class="col-sm-6">
									<input type="text" name="inputMinute" class="form-control form-control-sm" id="dateto" value="<?= $row['duration'] ?>">
									<small class="form-text text-muted">You can set only minute</small>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputStatus" class="col-sm-3 col-form-label text-right">Status</label>
								<div class="col-sm-6">
									<select name="inputStatus" class="form-control form-control-sm" id="inputStatus">
										<option value="1" <?= $row['status'] == 1 ? 'selected' : "" ?>>Active</option>
										<option value="0" <?= $row['status'] == 0 ? 'selected' : "" ?>>Inactive</option>
									</select>
								</div>
							</div>
							<div class="d-flex justify-content-md-center pt-3">
								<button type="reset" class="btn btn-light btn-sm px-5 mr-2" name="clearbtn">Clear</button>
								<button type="submit" class="btn btn-primary btn-sm px-5" name="submitbtn">Submit</button>
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