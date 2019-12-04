<?php
require_once('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

$errName = "";
$className = "";

if (isset($_POST['submitbtn'])) {
	$name = escape_input($_POST['inputTreatment']);

	if (empty($name)) {
		$errName = '<div class="invalid-feedback">This Field is required</div>';
		$className = $error_html['errClass'];
	} else {
		if (!preg_match($regrex['text'], $name)) {
			$errName = $error_html['invalidText'];
			$className = $error_html['errClass'];
		}
	}

	if (count($errName) == 0) {
		$treatstmt = $conn->prepare("INSERT INTO treatment_type (treatment_name, doctor_id) VALUE (?, ?)");
		$treatstmt->bind_param("si", $name, $doctor_row['doctor_id']);
		$treatstmt->execute();
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include CSS_PATH; ?>
	<script>

	</script>
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
						<form class="inline-form" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
							<div class="form-group row">
								<label for="inputTreatment" class="col-sm-3 col-form-label text-right">Treatment Type</label>
								<div class="col-sm-6">
									<input type="text" name="inputTreatment" id="inputTreatment" class="form-control form-control-sm <?= $className ?>" value="">
									<?= $errName ?>
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
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<table class="table">
							<tr>
								<td>Treatment ID</td>
								<td>Treatment Type</td>
								<td>Action</td>
							</tr>
							<?php
							$tresult = $conn->query("SELECT * FROM treatment_type WHERE doctor_id = '" . $doctor_row['doctor_id'] . "' ");
							if ($tresult->num_rows < 1) {
								echo '<tr><td colspan="3">No Record Found</td></tr>';
							} else {
								while ($trow = $tresult->fetch_assoc()) {
									?>
									<tr>
										<td><?= $trow['treatment_id'] ?></td>
										<td><?= $trow['treatment_name'] ?></td>
										<td>
											<a class="btn btn-sm btn-success" data-toggle="modal" href="#edit<?= $trow['treatment_id'] ?>">Edit</a>
											<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete<?= $trow['treatment_id'] ?>">Delete</a>
										</td>
									</tr>

									<div class="modal animated zoomIn faster" id="edit<?= $trow['treatment_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header" style="border:none;">
													<h5 class="modal-title" id="deleteModalLabel">Edit</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="" method="POST">
													<div class="modal-body">
														<div class="form-group">
															<input type="text" name="" id="" class="form-control" value="<?= $trow['treatment_name'] ?>">
														</div>
													</div>
													<div class="modal-footer" style="border:none;">
														<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
														<button type="button" class="btn btn-sm btn-primary">Save changes</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<div class="modal animated zoomIn faster" id="delete<?= $trow['treatment_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content">
												<div class="modal-header" style="border:none;">
													<!-- <h5 class="modal-title" id="deleteModalLabel">Delete</h5> -->
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="" method="POST">
													<div class="modal-body">
														Are you sure want to delete <strong><?= $trow['treatment_name'] ?></strong> ?
													</div>
													<div class="modal-footer" style="border:none;">
														<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
														<button type="button" class="btn btn-sm btn-danger">Delete</button>
													</div>
												</form>
											</div>
										</div>
									</div>
							<?php
								}
							}
							?>
							<tr>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- End Page Content -->
	</div>
	<?php include JS_PATH; ?>
</body>

</html>