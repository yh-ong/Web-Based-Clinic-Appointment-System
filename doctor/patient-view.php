<?php
require_once('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

$patient_id = $_GET["id"];
$result = $conn->query("SELECT * FROM patients WHERE patient_id = $patient_id");
$row = $result->fetch_assoc();

$medresult = $conn->query(
	"SELECT * FROM medical_diagnosis M 
	INNER JOIN clinics C ON M.clinic_id = C.clinic_id
	INNER JOIN patients P ON M.patient_id = P.patient_id
	WHERE M.patient_id = $patient_id"
);
$medrow = $medresult->fetch_assoc();
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


	tbody tr td:first-child {
		width: 8em;
		min-width: 10em;
		max-width: 10em;
		word-break: break-all;
	}
</style>

<body>
	<?php include NAVIGATION; ?>
	<!-- Page content holder -->
	<div class="page-content" id="content">
		<?php include HEADER; ?>
		<!-- Page content -->
		<div class="row">
			<div class="col-12">
				<div class="ml-auto">
					<button class="btn btn-success px-5 float-right" data-toggle="modal" data-target="#followup">Consultation Finish</button>
				</div>
				<div class="modal fade" id="followup" tabindex="-1" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h6 class="modal-title">Follow Up Visit</h6>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>Do <?= $row["patient_firstname"] . ' ' . $row["patient_lastname"] ?> need follow-up visit?</p>
							</div>
							<div class="modal-footer">
								<a href="./appointment.php" class="btn btn-secondary">No</a>
								<button type="button" class="btn btn-primary">Yes</button>
							</div>
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
								<p><?= $row["patient_age"] ?>,&nbsp; <?= strtoupper($row["patient_gender"]) ?> </p>
							</div>
							<div class="flex-fill bd-highlight">
								<p class="text-muted">Last Visit</p>
								<h5 class="font-weight-bold">
									<?php if ($medresult->num_rows == 0) {
										echo 'New Patient';
									} else {
										echo '21-03-2019';
									}
									?>
								</h5>
							</div>
							<div class="flex-fill bd-highlight">
								<p class="text-muted">Diagnosis</p>
								<h5 class="font-weight-bold">Throat Disease</h5>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 mb-3">
				<nav class="nav nav-pills flex-column flex-sm-row mb-3">
					<a class="flex-sm-fill text-sm-center nav-link active" data-toggle="pill" href="#tab1">General</a>
					<a class="flex-sm-fill text-sm-center nav-link" data-toggle="pill" href="#tab2">Health Record <span class="badge badge-light">4</span></a>
					<a class="flex-sm-fill text-sm-center nav-link" data-toggle="pill" href="#tab3">Link</a>
				</nav>
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="pills-home-tab">
						<div>
							<h6>Diagnosis Record</h6>
							<div class="card">
								<div class="card-body">
									<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
										<div>
											<label for="medrecord">Medical Description</label>
											<textarea name="medrecord" class="form-control" id="medrecord" cols="30" rows="5"></textarea>
										</div>
										<div class="mt-1">
											<label for="medrecord">Advise</label>
											<textarea name="medrecord" class="form-control" id="medrecord" cols="20" rows="5"></textarea>
										</div>
										<button type="submit" class="btn btn-primary px-5 mt-3 float-right">Save</button>
									</form>
									<?php

									?>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="pills-profile-tab">
						<div class="row">
							<div class="col-md-6">
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

							<div class="col-md-6">
								<h6>Medical History</h6>
								<div class="card">
									<div class="card-body">
										<table class="table">
											<thead>
												<tr>
													<th scope="col">Med ID #</th>
													<th scope="col">Type</th>
													<th scope="col">Date Recorded</th>
													<th scope="col">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$tresult = $conn->query("SELECT * FROM medical_diagnosis WHERE patient_id = $patient_id");
												if ($tresult->num_rows == 0) {
													echo '<td colspan="4">No Record Found</td>';
												} else {
													while ($trow = $tresult->fetch_assoc()) {
														?>
														<tr>
															<th scope="row">1</th>
															<td>illness</td>
															<td>2019-01-01</td>
															<td><button class="btn btn-sm btn-primary">View</button></td>
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

					<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="pills-contact-tab">
						3
					</div>
				</div>
			</div>

		</div>
		<!-- End Page Content -->
	</div>

	<?php include JS_PATH; ?>
</body>

</html>