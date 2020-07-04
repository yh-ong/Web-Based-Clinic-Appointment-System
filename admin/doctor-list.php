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
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="data-tables">
							<?php
							function headerTable()
							{
								$header = array("Doctor Name", "Speciality", "Contact", "Email", "Date Added");
								for ($i = 0; $i < count($header); $i++) {
									echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
								}
							}
							?>
							<table id="datatable" class="table" style="width:100%">
								<thead>
									<tr>
										<?= headerTable(); ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$tresult = $conn->query("SELECT * FROM doctors LEFT JOIN speciality ON doctors.doctor_speciality = speciality.speciality_id");
									if ($tresult->num_rows === 0) {
										echo '<div>No Doctor Record</div>';
									} else {
										while ($row = $tresult->fetch_assoc()) { ?>
											<tr>
												<td>Dr. <?= $row["doctor_firstname"] . ' ' . $row["doctor_lastname"] ?></td>
												<td><?= $row["speciality_name"] ?></td>
												<td><?= $row["doctor_contact"] ?></td>
												<td><?= $row["doctor_email"] ?></td>
												<td><?= $row["date_created"] ?></td>
												<!-- <td><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</button></td> -->
											</tr>
									<?php
										}
									}
									?>
								</tbody>
								<tfoot>
									<tr>
										<?= headerTable(); ?>
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
<?php
if (isset($_POST["deletebtn"])) {

	$id = $_POST["doctor_id"];
	if (mysqli_query($conn, "DELETE FROM doctor WHERE doctor_id = $id")) {
		echo "<script>window.location.href='doctor-list.php'</script>";
	} else {
		echo "Error deleting record: " . mysqli_error($conn);
	}
	mysqli_close($conn);
}
?>