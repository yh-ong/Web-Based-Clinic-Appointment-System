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
			<div class="col-12 mt-3">
				<!-- <div class="ml-auto">
					<button class="btn btn-sm btn-primary px-5 float-right" data-toggle="modal" data-target="#addschedule">Add Schedule</button>
				</div> -->
				<button class="btn btn-sm btn-primary px-5" data-toggle="modal" data-target="#addschedule">Add Schedule</button>
				<div class="modal fade" tabindex="-1" role="dialog" id="addschedule">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Add Schedule</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
								<div class="modal-body">
									<div class="form-group">
										<label for="datepickerfrom">From Date</label>
										<input type="text" id="datepickerfrom" name="datefrom" class="form-control">
									</div>
									<div class="form-group">
										<label for="datepickerto">Until Date</label>
										<input type="text" id="datepickerto" name="dateto" class="form-control">
									</div>
								</div>
								<div class="modal-footer">
									<button type="submit" name="savebtn" class="btn btn-primary">Add</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php
						function headerTable()
						{
							$header = array("Date From", "Date Until", "Time Slot", "Week", "Status", "Action");
							$arrlen = count($header);
							for ($i = 0; $i < $arrlen; $i++) {
								echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
							}
						}
						?>
						<div class="data-tables">
							<table id="datatable2" class="table table-responsive-lg nowrap" style="width:100%">
								<thead>
									<tr>
										<?php headerTable(); ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$tresult = mysqli_query($conn, "SELECT * FROM schedule WHERE doctor_id = '" . $doctor_row['doctor_id'] . "'");
									if ($tresult->num_rows == 0) {
										echo '<tr><td>No Record Found</td></tr>';
									} else {
										while ($trow = mysqli_fetch_assoc($tresult)) { ?>
											<tr>
												<td><?= $trow["date_from"] ?></td>
												<td><?= $trow["date_to"] ?></td>
												<td><?= $trow["schedule_time"] ?></td>
												<td><?= $trow["schedule_week"] ?></td>
												<td><?= ($trow['status'] == 1) ? '<span class="badge badge-success px-3 py-1">Active</span></td>' : '<span class="badge badge-warning px-3 py-1">Inactive</span></td>' ?>
													<td><a href="sch-edit.php?scheduleid=<?= $trow["schedule_id"] ?>" class="btn btn-sm btn-outline-info"><i class="fa fa-pen"></i> Edit</a></td>
											</tr>
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
				$('#datepickerfrom').datetimepicker({
					format: 'YYYY-MM-DD',
				});
				$('#datepickerto').datetimepicker({
					useCurrent: false,
					format: 'YYYY-MM-DD',
				});
				$("#datepickerfrom").on("dp.change", function(e) {
					$('#datepickerto').data("DateTimePicker").minDate(e.date);
				});
				$("#datepickerto").on("dp.change", function(e) {
					$('#datepickerfrom').data("DateTimePicker").maxDate(e.date);
				});
			});
		</script>
</body>

</html>
<?php
if (isset($_POST['savebtn'])) {
	$from = $_POST['datefrom'];
	$to = $_POST['dateto'];
	$status = 1;

	$stmt = $conn->prepare("INSERT INTO schedule (date_from, date_to, status, doctor_id, clinic_id) VALUE (?,?,?,?,?)");
	$stmt->bind_param("sssss", $from, $to, $status, $doctor_row['doctor_id'], $doctor_row['clinic_id']);
	$stmt->execute();
	$stmt->close();
	$id = $conn->insert_id;

	header('Location: sch-edit.php?id=' . $id);
}
?>