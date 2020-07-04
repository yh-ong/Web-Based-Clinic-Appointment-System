<?php
require_once('../config/autoload.php');
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
						<!-- Datatable -->
						<?php
						function headerTable()
						{
							$header = array("Name", "IC/Passport Number", "Phone", "Email", "Action");
							$arrlen = count($header);
							for ($i = 0; $i < $arrlen; $i++) {
								echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
							}
						}
						?>
						<div class="data-tables">
							<table id="datatable" class="table" style="width:100%">
								<thead>
									<tr>
										<?php headerTable(); ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$que = "SELECT DISTINCT patients.patient_id, patients.patient_lastname, patients.patient_firstname, patients.patient_identity, patients.patient_contact, patients.patient_email FROM appointment, patients WHERE appointment.patient_id = patients.patient_id AND appointment.doctor_id = '".$doctor_row['doctor_id']."' AND appointment.status = 1 ";
									$tresult = $conn->query($que);
									while ($trow = $tresult->fetch_assoc()) {
										?><tr>
											<td><?= $trow["patient_lastname"] . ' ' . $trow["patient_firstname"]; ?></td>
											<td><?= $trow["patient_identity"]; ?></td>
											<td><?= $trow["patient_contact"]; ?></td>
											<td><?= $trow["patient_email"]; ?></td>
											<td>
												<a href="patient-view.php?id=<?= encrypt_url($trow["patient_id"]); ?>" class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i> View</a>
											</td>
										</tr>
									<?php
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<?php headerTable(); ?>
									</tr>
								</tfoot>
							</table>
						</div>
						<!-- End Datatable -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Content -->
	</div>

	<?php include JS_PATH; ?>
</body>

</html>