<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include CSS_PATH; ?>
	<link rel="stylesheet" href="../assets/css/clinic/schedule.css">
</head>

<body>
	<?php include NAVIGATION; ?>
	<div class="page-content" id="content">
		<?php include HEADER; ?>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<?php
						function headerTable()
						{
							$header = array("Day", "Start Time", "End Time", "Consultation Time", "Statis", "Action");
							$arrlen = count($header);
							for ($i = 0; $i < $arrlen; $i++) {
								echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
							}
						}
						?>
						<div class="data-tables">
							<table id="datatable" class="table table-responsive-lg nowrap" style="width:100%">
								<thead>
									<tr>
										<?php headerTable(); ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$tresult = mysqli_query($conn, "SELECT * FROM schedule WHERE doctor_id = '" . $doctor_row['doctor_id'] . "'");
									while ($trow = mysqli_fetch_assoc($tresult)) : ?>
										<tr>
											<td><?= $trow["day"] ?></td>
											<td><?= $trow["start_time"] ?></td>
											<td><?= $trow["end_time"] ?></td>
											<td><?= $trow["duration"] ?> <small>per minuate</small></td>
											<td><?= ($trow['status'] == 1) ? '<span class="badge badge-success px-3 py-1">Active</span></td>' : '<span class="badge badge-warning px-3 py-1">Inactive</span></td>' ?>
											<td><a href="schedule-edit.php?scheduleid=<?= $trow["schedule_id"] ?>" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i> Edit</a></td>
										</tr>
									<?php endwhile; ?>
								</tbody>
								<tfoot>
									<tr>
										<?php headerTable(); ?>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>

			<?php
			function displayTime(string $day, int $sec)
			{
				global $conn;
				$output = "";

				$bgcolor = array("red","orange","purple","navy","yellow","blue");
				$randcolor = $bgcolor[array_rand($bgcolor)];

				$result = $conn->query("SELECT * FROM schedule WHERE day = '".$day."' ");
				$row = mysqli_fetch_assoc($result);
				$open = date("H:i", strtotime($row['start_time']));
				$close = date("H:i", strtotime($row['end_time']));
				
				if ($result->num_rows < 1) {
					$output .= '<div class="event gray"><span class="title">No Record</span></div>';
				} else {
					for ($i = strtotime($open); $i < strtotime($close); $i += $sec) {
						$output .= '<div class="event '.$randcolor.'">';
						$output .= '<span class="title">'.date("H:i", $i).'</span>';
						$output .= '</div>';
					}
				}
				return $output;
			}

			function selectTimesOfDay()
			{
				$open_time = strtotime("10:00");
				$close_time = strtotime("12:00");
				// $now = time();
				$output = "";
				// Minuate Interval = Second/60
				// Second = {{10}}* 60
				for ($i = $open_time; $i < $close_time; $i += 600) {
					// if( $i < $now) continue;
					// $output .= "<option>".date("l - H:i",$i)."</option>";
					$output .= "<option>" . date("H:i", $i) . "</option>";
				}
				return $output;
			}
			?>

			<div class="col-12">
				<div class="card">
					<div class="container-fluid">

						<div class="row day-columns">
							<div class="day-column">
								<div class="day-header">Monday</div>
								<div class="day-content">
									<?= displayTime('Monday', 600); ?>
								</div>
								<div class="day-footer"><?= count(displayTime('Monday', 600)) ?> tasks</div>
							</div>

							<div class="day-column">
								<div class="day-header">Tuesday</div>
								<div class="day-content">
									<?= displayTime('Tuesday', 600); ?>
								</div>
								<div class="day-footer">2 Tasks</div>
							</div>

							<div class="day-column">
								<div class="day-header">Wednesday</div>
								<div class="day-content">
									<?= displayTime('Wednesday', 600); ?>
								</div>
								<div class="day-footer">4 tasks</div>
							</div>

							<div class="day-column">
								<div class="day-header">Thursday</div>
								<div class="day-content">
									<?= displayTime('Thursday', 600); ?>
								</div>
								<div class="day-footer">7 Tasks</div>
							</div>
							
							<div class="day-column">
								<div class="day-header">Friday</div>
								<div class="day-content">
									<?= displayTime('Friday', 600); ?>
								</div>
								<div class="day-footer">7 Tasks</div>
							</div>

							<div class="day-column">
								<div class="day-header">Saturday</div>
								<div class="day-content">
								<?= displayTime('Saturday', 600); ?>
								</div>
								<div class="day-footer">4 Tasks</div>
							</div>

							<div class="day-column">
								<div class="day-header">Sunday</div>
								<div class="day-content">
								<?= displayTime('Sunday', 600); ?>
								</div>
								<div class="day-footer">2 Tasks</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- End Page Content -->
		</div>

		<?php include JS_PATH; ?>
</body>

</html>