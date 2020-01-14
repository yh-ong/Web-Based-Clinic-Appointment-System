<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

$patient_id = $_GET["id"];
$result = $conn->query("SELECT * FROM patients WHERE patient_id = $patient_id");
$row = $result->fetch_assoc();

$patient_age = date('Y') - date('Y', strtotime($row['patient_dob']));

$medresult = $conn->query(
	"SELECT * FROM medical_record M 
	INNER JOIN clinics C ON M.clinic_id = C.clinic_id
	INNER JOIN patients P ON M.patient_id = P.patient_id
	WHERE M.patient_id = $patient_id"
);
$medrow = $medresult->fetch_assoc();

$errors = array();

if (isset($_POST['prescriptionbtn'])) {
	$sympton = escape_input($_POST['sympton']);
	$diagnosis = escape_input($_POST['diagnosis']);
	$advice = escape_input($_POST['advice']);

	if (empty($sympton)) {
		array_push($errors, "Symptons is required");
	}

	if (empty($diagnosis)) {
		array_push($errors, "Dianogsis is required");
	}

	if (empty($advice)) {
		array_push($errors, "Advise is required");
	}

	if (count($errors) == 0) {
		$stmt = $conn->prepare("INSERT INTO medical_record (med_sympton, med_diagnosis, med_advice, med_date, patient_id, clinic_id, doctor_id) VALUE (?,?,?,?,?,?,?) ");
		$stmt->bind_param("sssssss", $sympton, $diagnosis, $advice, $date_created, $patient_id, $doctor_row['clinic_id'], $doctor_row['doctor_id']);
		$stmt->execute();
		$stmt->close();
		header('Location: '.$_SERVER['REQUEST_URI']);
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include CSS_PATH; ?>
</head>

<style>
	.patient-status-bar .d-flex .flex-fill {
		border-right: 1px solid #ddd;
		padding: .5rem !important;
		margin: 0 10px 0 0;
	}

	.patient-status-bar .d-flex .flex-fill:last-child {
		border-right: 0;
	}


	/* tbody tr td:first-child {
		width: 8em;
		min-width: 10em;
		max-width: 10em;
		word-break: break-all;
	} */
</style>

<body>
	<?php include NAVIGATION; ?>
	<!-- Page content holder -->
	<div class="page-content" id="content">
		<?php include HEADER; ?>
		<!-- Page content -->
		<div class="row">
			<div class="col-12">
				<div class="modal fade" id="followup" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="modal-title">Add <strong><?= $row["patient_firstname"] . ' ' . $row["patient_lastname"] ?></strong> Follow Up Visit</h6>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label>Treatment Type</label>
									<select name="inputTreatment" id="inputTreatment" class="form-control">
										<?php
											$treatresult = mysqli_query($conn, "SELECT * FROM treatment_type WHERE doctor_id = '" . $doctor_row['doctor_id'] . "'");
											while($treatrow = mysqli_fetch_assoc($treatresult)) {
												echo '<option value='.$treatrow['treatment_name'].'>'.$treatrow['treatment_name'].'</option>';
											}
										?>
									</select>
								</div>
								<div class="form-row">
									<div class="form-group col-md-6">
										<label>Select Date</label>
										<div id="datepicker" onclick="getDate()"></div>
									</div>
									<div class="form-group">
										<label>Select Time</label>
										<div id="responsecontainer">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" name="appointmentbtn" class="btn btn-primary">Save</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="prescription" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="modal-title">Add New Prescription</h6>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST">
								<?= display_error();?>
								<div class="modal-body">
									<div class="form-group">
										<label>Symptons</label>
										<textarea name="sympton" class="form-control" id="sympton" cols="30" rows="3"></textarea>
									</div>
									<div class="form-group">
										<label>Diagnosis</label>
										<input type="text" name="diagnosis" class="form-control" id="diagnosis">
									</div>
									<div class="form-group">
										<label>Advice</label>
										<textarea name="advice" class="form-control" id="advice" cols="30" rows="3"></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" name="prescriptionbtn" class="btn btn-primary">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<!-- Card Content -->
				<div class="card patient-status-bar">
					<div class="card-body">
						<div class="d-flex bd-highlight">
							<div class="flex-fill bd-highlight">
								<p class="text-muted">Patient Info</p>
								<h5 class="font-weight-bold"><?php echo $row["patient_lastname"] . ' ' . $row["patient_firstname"] ?></h5>
								<p><?= $patient_age ?>,&nbsp; <?= strtoupper($row["patient_gender"]) ?> </p>
							</div>
							<div class="flex-fill bd-highlight">
								<p class="text-muted">Last Visit</p>
								<h5 class="font-weight-bold">
									<?php if ($medresult->num_rows == 0) {
										echo 'New Patient';
									} else {
										echo date_format(new DateTime($medrow['med_date']), 'Y-m-d');
									}
									?>
								</h5>
							</div>
							<div class="flex-fill bd-highlight">
								<p class="text-muted">Diagnosis</p>
								<h5 class="font-weight-bold">
									<?php if ($medresult->num_rows == 0) {
										echo 'New Patient';
									} else {
										echo $medrow['med_sympton'];
									}
									?>
								</h5>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 mb-3">
				<nav class="navbar px-0 mb-3">
					<div class="nav nav-pills mr-auto">
						<a class="nav-item text-sm-center nav-link active" data-toggle="pill" href="#tab1">Prescription Info</a>
						<a class="nav-item text-sm-center nav-link" data-toggle="pill" href="#tab2">Medical Info</a>
						<a class="nav-item text-sm-center nav-link" data-toggle="pill" href="#tab3">Appointment Record</a>
					</div>
					<div class=" nav nav-pills ml-auto">
						<a class="nav-item btn btn-sm btn-link" data-toggle="modal" href="#prescription">Add Prescription</a>
						<a class="nav-item btn btn-sm btn-link" data-toggle="modal" href="#followup">Add Appointment</a>
					</div>
				</nav>

				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1">
						<div class="card">
							<div class="card-body">
								<table class="table nowrap">
									<thead>
										<th>Symptons</th>
										<th>Diagnosis</th>
										<th>Date Recorded</th>
										<th>Action</th>
									</thead>
									<tbody>
										<?php
										$tresult = $conn->query("SELECT * FROM medical_record WHERE patient_id = $patient_id");
										if ($tresult->num_rows == 0) {
											echo '<td colspan="4">No Record Found</td>';
										} else {
											while ($trow = $tresult->fetch_assoc()) {
												?>
												<tr>
													<td><?= $trow['med_sympton'] ?></td>
													<td><?= $trow['med_diagnosis'] ?></td>
													<td><?= $trow['med_date'] ?></td>
													<td><button data-toggle="modal" data-target="#viewdiagnosis<?= $trow['med_id']?>" class="btn btn-sm btn-primary px-3">View</button></td>
												</tr>

												<div class="modal fade" id="viewdiagnosis<?= $trow['med_id']?>" tabindex="-1" role="dialog">
													<div class="modal-dialog" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h6 class="modal-title">View Details</h6>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<div class="row">
																	<p class="col-sm-3 text-right"><b>Symptons</b></p>
																	<div class="col-sm-6">
																	<p><?= $trow['med_sympton'] ?></p>
																	</div>
																</div>
																<div class="row">
																	<p class="col-sm-3 text-right"><b>Diagnosis</b></p>
																	<div class="col-sm-6">
																	<p><?= $trow['med_diagnosis'] ?></p>
																	</div>
																</div>
																<div class="row">
																	<p class="col-sm-3 text-right"><b>Advice</b></p>
																	<div class="col-sm-6">
																	<p><?= $trow['med_advice'] ?></p>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															</div>
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

					<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2">
						<div class="row">
							<div class="col-md-12">
								<h6>Latest Status</h6>
								<div class="card">
									<div class="card-body">
										<ul class="list-unstyled">
											<li class="media">
												<div class="media-body">
													<div><small class="text-muted">2019-08-12</small></div>
													<h5 class="mt-0 mb-1">Visit at YH Clinic Centre</h5>
													Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
												</div>
												</p>
											<li class="media my-4">
												<div class="media-body">
													<div><small class="text-muted">2019-05-27</small></div>
													<h5 class="mt-0 mb-1">illness</h5>
													Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3">
						<div class="card">
							<div class="card-body">
								<table class="table nowrap">
									<thead>
										<th>Date</th>
										<th>Treatment</th>
									</thead>
									<tbody>
										<?php
										$tresult = $conn->query("SELECT * FROM appointment WHERE patient_id = $patient_id");
										if ($tresult->num_rows == 0) {
											echo '<td colspan="2">No Record Found</td>';
										} else {
											while ($trow = $tresult->fetch_assoc()) {
												?>
												<tr>
													<td><?= $trow['app_date'] ?></td>
													<td><?= $trow['treatment_type'] ?></td>
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
			</div>

		</div>
		<!-- End Page Content -->
	</div>

	<?php include JS_PATH; ?>
	<script type="text/javascript">
		$(function() {
			$('#datepicker').datetimepicker({
				inline: true,
				minDate: '<?= $current_date ?>',
				format: 'YYY-MM-DD',
			});
		}).on('dp.change', function(event) {
			var formatted = event.date.format('YYYY-MM-DD');
			loadData(formatted);
		});

		function loadData(formatted) {
			$.ajax({
				type: "POST",
				data: {
					date: formatted
				},
				url: 'loadSchedule.php',
				dateType: "html",
				success: function(response) {
					$("#responsecontainer").html(response);
				}
			});
		}


		$('#followup').modal('show');
	</script>
</body>

</html>