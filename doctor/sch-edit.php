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

if (isset($_POST['submitbtn'])) {
	$time = escape_input($_POST['inputTime']);
	$duration = escape_input($_POST['inputDuration']);

	if ($time != "" && $duration != "") {
		$status = 1;

		$stmt = $conn->prepare("INSERT INTO schedule_detail (time_slot, duration, status, schedule_id) VALUE (?,?,?,?)");
		$stmt->bind_param("ssss", $time, $duration, $status, $id);
		$stmt->execute();
		$stmt->close();

		header('Location: ' . htmlspecialchars($_SERVER['REQUEST_URI']));
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
			<div class="col-md-4 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form name="frm" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">
							<div class="form-group">
								<label for="inputTime">Time Slot</label>
								<input type="text" name="inputTime" class="form-control timepicker" id="inputTime" placeholder="From">
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputDuration">Duration</label>
									<select name="inputDuration" class="form-control <?= $classMin ?>" id="inputDuration">
										<?php
										for ($i = 15; $i <= 60; $i += 15) {
											echo '<option value="' . $i . '">' . $i . ' mins</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="d-flex justify-content-md-center pt-2">
								<button type="reset" class="btn btn-light btn-sm px-5 mr-2" name="clearbtn">Clear</button>
								<button type="submit" class="btn btn-primary btn-sm px-5" name="submitbtn">Add</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-body">
						<div class="data-tables">
							<table id="datatable2" class="table table-responsive-lg nowrap" style="width: 100%">
								<thead>
									<tr>
										<th>Time Slot</th>
										<th>Duration</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$tresult = mysqli_query($conn, "SELECT * FROM schedule_detail WHERE schedule_id = '" . $id . "' ORDER BY time_slot");
									if ($tresult->num_rows == 0) {
										echo '<tr><td colspan="3">No Record Found</td></tr>';
									} else {
										while ($trow = mysqli_fetch_assoc($tresult)) { ?>
											<tr>
												<td><?= $trow["time_slot"] ?></td>
												<td><?= $trow["duration"] ?> <small>per minuate</small></td>
												<td>
													<button data-toggle="modal" data-target="#edit<?= $trow['schdetail_id'] ?>" class="btn btn-sm btn-outline-info"><i class="fa fa-pen"></i> Edit</button>
													<button data-toggle="modal" data-target="#delete<?= $trow['schdetail_id'] ?>" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i>Delete</button>
												</td>
											</tr>
											<div class="modal fade" tabindex="-1" role="dialog" id="edit<?= $trow['schdetail_id'] ?>">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Edit <?= $trow['time_slot'] ?> Schedule</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<form action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="POST">
															<div class="modal-body">
																<input type="hidden" name="inputSchID" value="<?= $trow["schdetail_id"] ?>">
																<div class="form-group">
																	<label for="inputTime">Time Slot</label>
																	<input type="text" name="inputEditTime" class="form-control timepicker" id="inputTime" placeholder="Time Slot" value="<?= $trow['time_slot'] ?>">
																</div>
																<div class="form-group">
																	<label for="">Duration</label>
																	<select name="inputEditDuration" class="form-control <?= $classMin ?>" id="inputMinute">
																		<?php
																				for ($i = 15; $i <= 60; $i += 15) {
																					?>
																			<option value="<?= $i ?>" <?= ($trow['duration'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
																		<?php
																				}
																				?>
																	</select>
																</div>
															</div>
															<div class="modal-footer">
																<button type="submit" name="editbtn" class="btn btn-primary">Save</button>
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
														</form>
													</div>
												</div>
											</div>

											<div class="modal fade" tabindex="-1" role="dialog" id="delete<?= $trow["schdetail_id"]; ?>">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">Delete</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														</div>
														<form method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">
														<div class="modal-body">
															<input type="hidden" name="inputDeleteID" value="<?= $trow["schdetail_id"]; ?>">
															<p>Are you sure to remove ?</p>
														</div>
														<div class="modal-footer">
															<button type="submit" name="deletebtn" class="btn btn-danger">Delete</button>
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
		</script>
</body>

</html>
<?php
$currentLink = htmlspecialchars($_SERVER['REQUEST_URI']);

if (isset($_POST["editbtn"])) {
	$time = escape_input($_POST['inputEditTime']);
	$duration = escape_input($_POST['inputEditDuration']);
	$status = 1;
	$schid = escape_input($_POST["inputSchID"]);

	$editstmt = $conn->prepare("UPDATE schedule_detail SET time_slot = ?, duration = ?, status = ? WHERE schdetail_id = ?");
	$editstmt->bind_param("ssss", $time, $duration, $status, $schid);
	
	if ($editstmt->execute()) {
		echo '<script>
			Swal.fire({ title: "Great!", text: "Successful Updated!", type: "success" }).then((result) => {
				if (result.value) { window.location.href = "'.$currentLink.'"; }
			});
		</script>';
	} else {
		echo '<script>
			Swal.fire({ title: "Oops!", text: "Error Updated!", type: "error" }).then((result) => {
				if (result.value) { window.location.href = "'.$currentLink.'"; }
			});
		</script>';
	}
	$editstmt->close();
}


if (isset($_POST['deletebtn'])) {
	$delid = escape_input($_POST['inputDeleteID']);

	$detailstmt = $conn->prepare("DELETE FROM schedule_detail WHERE schdetail_id = ?");
	$detailstmt->bind_param("s", $delid);

	if ($detailstmt->execute()) {
		echo '<script>
			Swal.fire({ title: "Great!", text: "Successful Deleted!", type: "success" }).then((result) => {
				if (result.value) { window.location.href = "'.$currentLink.'"; }
			});
		</script>';
	} else {
		echo "Error: " . $query . "<br>" . mysqli_error($conn);
	}
	$detailstmt->close();
}