<?php
include('../config/autoload.php');

$date = $_POST["date"];

// $query = "SELECT * 
// 		FROM schedule s 
// 		JOIN schedule_detail sd ON s.schedule_id = sd.schedule_id";

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
			echo '<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="button" aria-pressed="false" autocomplete="off">' . $row["time_slot"] . '</button>';
		}
	}
}

// function getSpecificDays($y, $m, $day)
// {
// 	return new DatePeriod(
// 		new DateTime("first $day of $y-$m"),
// 		DateInterval::createFromDateString("next $day"),
// 		new DateTime("last day of $y-$m")
// 	);
// }

// foreach (getSpecificDays(2019, 12, $day) as $weekofday) {
// 	echo $weekofday->format("l, Y-m-d\n");
// }

// function getTotalDatesArray($year, $month, $day)
// {
// 	$date_ar = array();
// 	$from = $year . "-" . $month . "-01";
// 	$t = date("t", strtotime($from));

// 	for ($i = 1; $i < $t; $i++) {
// 		if (strtolower(date("l", strtotime($year . "-" . $month . "-" . $i))) == $day) {
// 			$j = $i > 9 ? $i : "0" . $i;
// 			$date_ar[] = $year . "-" . $month . "-" . $j;
// 		}
// 	}
// 	return $date_ar;
// }

// print_r(getTotalDatesArray('2019','12', strtolower($day)));

// function intervalTime() {
// 	global $row, $result;
// 	// $start = date("H:i", strtotime($row['morning_start']));
// 	// $end = date("H:i", strtotime($row['morning_end']));
// 	$sec = $row['duration'];

// 	if ($result->num_rows < 1) {
// 		echo 'No Time Added';
// 	} else {
// 		for ($i= strtotime($start); $i < strtotime($end); $i+= $sec) { 
// 			echo '<button type="button" class="btn btn-sm btn-outline-primary" data-toggle="button" aria-pressed="false" autocomplete="off">1:00 PM</button>';
// 		}
// 	}
// }