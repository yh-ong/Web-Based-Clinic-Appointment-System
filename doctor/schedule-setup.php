<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');
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
						<form name="report_frm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
							<div class="form-group row">
								<label for="inputDoctor" class="col-sm-3 col-form-label text-right">Dortor</label>
								<div class="col-sm-6">
									<input type="text" id="inputDoctor" class="form-control form-control-sm" value="<?= $doctor_row["doctor_lastname"].' '.$doctor_row["doctor_firstname"] ?>" disabled>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputDay" class="col-sm-3 col-form-label text-right">Select Day</label>
								<div class="col-sm-6">
									<?php foreach(array("Monday","Tuesday","Wednesday","Thurday","Friday","Saturday","Sunday") as $day) : ?>
										<div class="custom-control custom-checkbox custom-control-inline">
											<input class="custom-control-input" type="checkbox" id="<?=$day?>" value="<?=$day?>">
											<label class="custom-control-label" for="<?=$day?>"><?=$day?></label>
										</div>
									<?php endforeach ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputTime" class="col-sm-3 col-form-label text-right">Set Time Range</label>
								<div class="col-sm-6 input-group">
									<input type="text" name="inputTimeFrom" class="form-control form-control-sm timepicker" id="inputTimeFrom" placeholder="From">
									<input type="text" name="inputTimeTo" class="form-control form-control-sm timepicker" id="inputTimeTo" placeholder="To">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputMinute" class="col-sm-3 col-form-label text-right">Set Duration Time</label>
								<div class="col-sm-6">
									<input type="text" name="inputMinute" class="form-control form-control-sm" id="dateto">
									<small class="form-text text-muted">can set only minute</small>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputMinute" class="col-sm-3 col-form-label text-right">Status</label>
								<div class="col-sm-6">
									<select type="text" name="inputStatus" class="form-control form-control-sm" id="datefrom" placeholder="From Date">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
							</div>
							<div class="d-flex justify-content-md-center pt-4">
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