<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

$id = $_GET['scheduleid'];
$schedulestmt = $conn->prepare("SELECT * FROM schedule WHERE schedule_id = ?");
$schedulestmt->bind_param("i", $id);
$schedulestmt->execute();
$result = $schedulestmt->get_result();
$row = $result->fetch_assoc();
$schedulestmt->close();

$errDoctor = $errDay = $errFrom = $errUntil = $errMin = $errStatus = "";
$classDoctor = $classDay = $classFrom = $classUntil = $classMin = $classStatus = "";

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['submitbtn'])) {
	$day = escape_input($_POST['inputDay']);
	$min = escape_input($_POST['inputMinute']);
	$mor_start = escape_input($_POST['MorningStart']);
	$mor_end = escape_input($_POST['MorningEnd']);
	$aft_start = escape_input($_POST['AfternoonStart']);
	$aft_end = escape_input($_POST['AfternoonEnd']);
	$eve_start = escape_input($_POST['EveningStart']);
	$eve_end = escape_input($_POST['EveningEnd']);
	$status = 1;

	$stmt = $conn->prepare("INSERT INTO schedule_detail (week, morning_start, morning_end, afternoon_start, afternoon_end, evening_start, evening_end, duration, status, schedule_id) VALUE (?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssssss", $day, $mor_start, $mor_end, $aft_start, $aft_end, $eve_start, $eve_end, $min, $status, $id);
	$stmt->execute();
	$stmt->close();

	header('Location: ' . htmlspecialchars($_SERVER['REQUEST_URI']));
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
		<div class="col-12 mb-3 mt-3">
			<button class="btn btn-sm btn-primary px-5" type="button" data-toggle="modal" data-target="#addweek">Add Time</button>
		</div>

		<div class="modal fade" tabindex="-1" role="dialog" id="addweek">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Time</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form name="frm" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">
						<div class="modal-body">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="">Week</label>
									<select name="inputDay" id="inputDay" class="form-control form-control-sm">
										<?php $dayval = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
										foreach ($dayval as $week) : ?>
											<option value="<?= $week ?>"><?= $week ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-row">
								<?php
								$shift = array("Morning", "Afternoon", "Evening");
								foreach ($shift as $shiftval) {
									?>
									<div class="form-group col-md-4">
										<label><?= $shiftval ?> Session</label>
										<div class="input-group">
											<input type="text" name="<?= $shiftval ?>Start" class="form-control form-control-sm timepicker" id="<?= $shiftval ?>Start" placeholder="From">
											<input type="text" name="<?= $shiftval ?>End" class="form-control form-control-sm timepicker" id="<?= $shiftval ?>End" placeholder="To">
										</div>
									</div>
								<?php
								}
								?>
							</div>
							<div class="form-row">
								<div class="form-group">
									<label for="inputMinute">Duration</label>
									<select name="inputMinute" class="form-control form-control-sm <?= $classMin ?>" id="inputMinute">
										<?php
										for ($i = 5; $i <= 60; $i += 5) {
											echo '<option value="' . $i . '">' . $i . ' mins</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="data-tables">
							<table id="datatable2" class="table table-responsive-lg nowrap" style="width:100%">
								<thead>
									<tr>
										<th>Week</th>
										<th>Morning</th>
										<th>Afternoon</th>
										<th>Evening</th>
										<th>Duration</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$tresult = mysqli_query($conn, "SELECT * FROM schedule_detail WHERE schedule_id = '" . $id . "'");
									if ($tresult->num_rows == 0) {
										echo '<tr><td>No Record Found</td></tr>';
									} else {
										while ($trow = mysqli_fetch_assoc($tresult)) { ?>
											<tr>
												<td><?= $trow["week"] ?></td>
												<td><?= $trow["morning_start"] . ' -- ' . $trow["morning_end"] ?></td>
												<td><?= $trow["afternoon_start"] . ' -- ' . $trow["afternoon_end"] ?></td>
												<td><?= $trow["evening_start"] . ' -- ' . $trow["evening_end"] ?></td>
												<td><?= $trow["duration"] ?> <small>per minuate</small></td>
												<td>
													<button data-toggle="modal" data-target="#edit<?= $trow['schdetail_id'] ?>" class="btn btn-sm btn-outline-info"><i class="fa fa-pen"></i> Edit</button>
													<button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i>Delete</button>
												</td>
											</tr>
											<div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $trow['schdetail_id'] ?>">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Edit <?= $trow['week'] ?> Schedule</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="POST">
															<div class="modal-body">
																<?php
																		$shift = array("Morning", "Afternoon", "Evening");
																		foreach ($shift as $shiftval) {
																			?>
																	<div class="form-row">
																		<div class="form-group col-md-6">
																			<label for=""><?= $shiftval ?> Start</label>
																			<input type="text" id="" name="<?= $shiftval ?>Start" class="form-control form-control-sm timepicker" value="<?= $trow[strtolower($shiftval)."_start"] ?>">
																		</div>
																		<div class="form-group col-md-6">
																			<label for=""><?= $shiftval ?> End</label>
																			<input type="text" id="" name="<?= $shiftval ?>End" class="form-control form-control-sm timepicker" value="<?= $trow[strtolower($shiftval)."_end"] ?>">
																		</div>
																	</div>
																<?php
																		}
																		?>
																<div class="form-group">
																	<label for="">Duration</label>
																	<select name="inputMinute" class="form-control form-control-sm <?= $classMin ?>" id="inputMinute">
																		<?php
																				for ($i = 5; $i <= 60; $i += 10) {
																					?>
																			<option value="<?= $i ?>" <?= ($trow['duration'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
																		<?php
																				}
																				?>
																	</select>
																</div>
															</div>
															<div class="modal-footer">
																<button type="submit" name="savebtn" class="btn btn-primary">Save</button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
														</form>
													</div>
												</div>
											</div>
									<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- End Page Content -->
		</div>
		<?php include JS_PATH; ?>
		<script type="text/javascript">
			$(function() {
				$('.timepicker').datetimepicker({
					format: 'LT'
				});
			});

			$('#addweek').modal('show');
		</script>
</body>

</html>