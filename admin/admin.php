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
								$header = array("Name", "Email", "Action");
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
									$tresult = $conn->query("SELECT * FROM admin");
									if ($tresult->num_rows === 0) {
										echo '<div>No Admin Record</div>';
									} else {
                                        while ($row = $tresult->fetch_assoc()) { 
                                            $id = $row["admin_id"];
                                            $encrypt_id = urlencode(base64_encode($id));
                                            ?>
											<tr>
												<td><?= $row["admin_name"] ?></td>
												<td><?= $row["admin_email"] ?></td>
												<td><a href="admin-edit.php?aid=<?php echo $encrypt_id;?>" class="btn btn-sm btn-secondary"><i class="fa fa-pen"></i> Edit</a></td>
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