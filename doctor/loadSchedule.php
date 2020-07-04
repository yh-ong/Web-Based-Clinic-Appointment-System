<?php
include('../config/autoload.php');

$date = $_POST["date"];

$query = "SELECT * FROM schedule s
		LEFT JOIN schedule_detail sd ON s.schedule_id = sd.schedule_id 
		WHERE s.date_from <= '$date' AND s.date_to >= '$date' 
		ORDER BY sd.time_slot";

$result = $conn->query($query);

if ($result->num_rows == 0) {
	echo '<span>No Time Added</span>';
} else {
	while ($row = $result->fetch_assoc()) {
		$day = $row['schedule_week'];

		$dayofweek = date("l", strtotime($date));

		if ($dayofweek == $day) {
			$timeslot = $row["time_slot"];
			?>
				<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="button" aria-pressed="false" autocomplete="off" onClick="return getTime('<?= $timeslot ?>');"><?= $timeslot ?></button>
			<?php
		}
	}
}