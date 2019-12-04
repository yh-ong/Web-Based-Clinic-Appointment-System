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
			<?php
			$tlist = $conn->prepare("SELECT * FROM doctors WHERE clinic_id = ?");
			$tlist->bind_param("i", $clinic_row['clinic_id']);
			$tlist->execute();
			$tresult = $tlist->get_result();
			if ($tresult->num_rows === 0) {
				echo '<div>No Doctor Record</div>';
			} else {
				while ($trow = $tresult->fetch_assoc()) { ?>
					<div class="col-sm-6">
						<div class="card card-hover mb-3" style="height:200px;overflow:hidden;">
							<div class="row no-gutters">
								<div class="col-md-4">
									<img src="../uploads/<?= $trow["clinic_id"] ?>/doctor/<?= $trow["doctor_avatar"] ?>" class="card-img img-fluid">
								</div>
								<div class="col-md-8">
									<div class="card-body d-flex flex-column">
										<h6 class="card-title font-weight-bold"><?= $trow["doctor_lastname"] . ' ' . $trow["doctor_firstname"]; ?></h6>
										<p class="card-text"><b><?= $trow["doctor_speciality"]; ?></b></p>
										<p class="card-text"><?= $trow["doctor_email"]; ?></p>
										<p class="card-text"><?= $trow["doctor_contact"]; ?></p>
										<div class="mt-3">
											<a href="doctor-view.php?did=<?= encrypt_url($trow["doctor_id"]) ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye mr-1"></i> View</a>
											<a href="doctor-edit.php?cid=<?= encrypt_url($trow["doctor_id"]) ?>" class="btn btn-sm btn-secondary"><i class="fa fa-pen mr-1"></i> Edit</a>
											<a href= "#deleteid<?= encrypt_url($trow['doctor_id']) ?>" data-toggle="modal" class="btn btn-sm btn-danger" id="delete_product" data-id="<?php echo $trow["doctor_id"]; ?>"><i class="fa fa-trash mr-1"></i> Delete</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php
				}
			}
			?>
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