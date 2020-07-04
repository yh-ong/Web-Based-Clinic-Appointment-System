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
			<div class="col-md-4">
				<div class="card">
					<div class="card-body">
						<div class="form-group">
							<div id="datepicker"></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-8">
				<!-- Card Content -->
				<div class="card">
					<div class="card-body">
						<!-- Datatable -->
						<?php
						function headerTable()
						{
							$header = array("Name", "Time",  "Treatment", "Case","Arrive", "Status", "Action");
							for ($i = 0; $i < count($header); $i++) {
								echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
							}
						}
						?>
						<div class="data-tables">
							<table id="datatable" class="table table-responsive-lg nowrap">
								<thead>
									<tr>
										<?php headerTable(); ?>
									</tr>
								</thead>
								<tbody id="responsecontainer"></tbody>
							</table>
						</div>
						<!-- End Datatable -->
					</div>
				</div>
				<!-- End Card Content -->
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
			loadData(formatted,  <?= $doctor_row['doctor_id'] ?>);
		});

		function loadData(formatted, id) {
			$.ajax({
				type: "POST",
				data: {
					date: formatted,
					id: id,
				},
				url: 'loadAppointment.php',
				dateType: "html",
				success: function(response) {
					$("#responsecontainer").html(response);
				}
			});
		}
	</script>
</body>

</html>