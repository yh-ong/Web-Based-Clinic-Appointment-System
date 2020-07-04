<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include CSS_PATH; ?>
	<style>
		.rate-upper {
			margin-bottom: 25px;
		}
		
		.rate-bottom .row {
			margin-bottom: 5px;
		}

		.checked {
			color: orange;
		}

		.card-header {
			background: white;
		}
	</style>
</head>

<body>
	<?php include NAVIGATION; ?>
	<div class="page-content" id="content">
		<?php include HEADER; ?>
		<!-- Page content -->
		<div class="row">
			<div class="col-md-7">
				<?php
				function time_elapsed($datetime, $full = false)
				{
					$now = new DateTime;
					$ago = new DateTime($datetime);
					$diff = $now->diff($ago);

					$diff->w = floor($diff->d / 7);
					$diff->d -= $diff->w * 7;

					$string = array(
						'y' => 'year',
						'm' => 'month',
						'w' => 'week',
						'd' => 'day',
						'h' => 'hour',
						'i' => 'minute',
						's' => 'second',
					);
					foreach ($string as $k => &$v) {
						if ($diff->$k) {
							$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
						} else {
							unset($string[$k]);
						}
					}

					if (!$full) $string = array_slice($string, 0, 1);
					return $string ? implode(', ', $string) . ' ago' : 'just now';
				}

				$row = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(rating) as AVG FROM reviews WHERE doctor_id = ".$doctor_row['doctor_id']." "));
				$average = $row['AVG'];

				$row = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(rating) as FIVE FROM reviews WHERE rating = 5 AND doctor_id = ".$doctor_row['doctor_id']." "));
				$five = $row['FIVE'];
				$row = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(rating) as FOUR FROM reviews WHERE rating = 4 AND doctor_id = ".$doctor_row['doctor_id']." "));
				$four = $row['FOUR'];
				$row = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(rating) as THREE FROM reviews WHERE rating = 3 AND doctor_id = ".$doctor_row['doctor_id']." "));
				$three = $row['THREE'];
				$row = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(rating) as TWO FROM reviews WHERE rating = 2 AND doctor_id = ".$doctor_row['doctor_id']." "));
				$two = $row['TWO'];
				$row = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(rating) as ONE FROM reviews WHERE rating = 1 AND doctor_id = ".$doctor_row['doctor_id']." "));
				$one = $row['ONE'];

				$table_result = mysqli_query($conn, "SELECT * FROM reviews LEFT JOIN patients ON reviews.patient_id = patients.patient_id WHERE reviews.doctor_id = " . $doctor_row['doctor_id'] . "");
				$count = mysqli_num_rows($table_result);
				if ($count == 0) {
					print '<div class="card text-center"><div class="card-body"><h6>No Results Available</h6></div></div>';
				} else {
					while ($table_row = mysqli_fetch_assoc($table_result)) {
						?>
						<div class="card">
							<div class="card-header">
								<div class="d-flex w-100 justify-content-between">
									<div>
										<img src="../assets/img/empty/empty-avatar.jpg" class="rounded mr-3" width="30px">
										<span><?= $table_row["patient_firstname"].' '.$table_row["patient_lastname"] ?></span>
									</div>
									<small><b>Submitted</b> <?= time_elapsed($table_row['date']) ?></small>
								</div>
							</div>
							<div class="card-body">
								<div class="text-right">
									<?php
									for ($i = 1; $i <= 5; $i++) {
										$checked = "far fa-star";
										if($i <= $table_row['rating']) {
											$checked = "fas fa-star checked";
										}
										echo '<i class="'.$checked.'"></i>';
									}
									?>
								</div>
								<p><?=  $table_row["review"] ?></p>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
			<div class="col-md-5">
				<div class="card">
					<div class="card-body">
						<div class="rate-wrap">
							<div class="rate-upper">
								<h1 class="display-5"><?= round($average,1) ?> / 5</h1>
								<p>Average based on <?=$count?> reviews</p>
							</div>
							<div class="rate-bottom">
								<div class="row">
									<label for="" class="col-sm-2 text-right">5 Star</label>
									<div class="col-sm-8">
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: <?= $five/$count*100 . '%'?>" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<label for="" class="col-sm-2 text-left"><?= $five ?></label>
								</div>

								<div class="row">
									<label for="" class="col-sm-2 text-right">4 Star</label>
									<div class="col-sm-8">
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: <?= $four/$count*100 . '%'?>" aria-valuenow="<?= $four/$count*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<label for="" class="col-sm-2 text-left"><?= $four ?></label>
								</div>

								<div class="row">
									<label for="" class="col-sm-2 text-right">3 Star</label>
									<div class="col-sm-8">
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: <?= $three/$count*100 . '%'?>" aria-valuenow="<?= $three/$count*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<label for="" class="col-sm-2 text-left"><?= $three ?></label>
								</div>
								
								<div class="row">
									<label for="" class="col-sm-2 text-right">2 Star</label>
									<div class="col-sm-8">
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: <?= $two/$count*100 . '%'?>" aria-valuenow="<?= $two/$count*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<label for="" class="col-sm-2 text-left"><?= $two ?></label>
								</div>
								
								<div class="row">
									<label for="" class="col-sm-2 text-right">1 Star</label>
									<div class="col-sm-8">
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: <?= $one/$count*100 . '%'?>" aria-valuenow="<?= $one/$count*100 ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
									<label for="" class="col-sm-2 text-left"><?= $one ?></label>
								</div>

							</div>
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