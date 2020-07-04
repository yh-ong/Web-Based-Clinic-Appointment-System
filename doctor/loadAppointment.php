<?php
include('../config/autoload.php');

$date = $_POST['date'];
$id = $_POST['id'];

$query = "SELECT * FROM appointment, patients, doctors WHERE
 appointment.patient_id = patients.patient_id AND
 appointment.doctor_id = doctors.doctor_id AND
 appointment.doctor_id = $id AND appointment.app_date = '$date'
 ORDER BY SUBSTRING_INDEX(appointment.app_time, ' ', -1), SUBSTRING_INDEX(appointment.app_time, ' ', 1)
";
// $query = "SELECT * FROM appointment , patients, clinics, doctors WHERE
// JOIN patients ON appointment.patient_id = patients.patient_id 
// JOIN clinics ON appointment.clinic_id = clinics.clinic_id 
// JOIN doctors ON appointment.doctor_id = doctors.doctor_id 
// WHERE appointment.doctor_id = $id
// ORDER BY appointment.app_date
// ";
$tlist = $conn->query($query);

while ($trow = $tlist->fetch_assoc()) {
	if ($tlist->num_rows == 0) {
		echo '<p>No result</p>';
	} else {
		?>
		<tr>
			<td><?= $trow['patient_lastname'] . ' ' . $trow['patient_firstname'] ?></td>
			<td><?= $trow['app_time'] ?></td>
			<td><?= $trow['treatment_type'] ?></td>
			<?php
				if ($trow['consult_status'] == 1) {
					echo '<td><span class="badge badge-success px-3 py-1">Complete</span></td>';
				} else {
					echo '<td><span class="badge badge-warning px-3 py-1">Not Complete</span></td>';
				}
			?>
			<?php
				if ($trow['arrive_status'] == 1) {
					echo '<td><span class="badge badge-success px-3 py-1">Arrived</span></td>';
				} else {
					echo '<td><span class="badge badge-warning px-3 py-1">On the way</span></td>';
				}
			?>
			<?php
				if ($trow['status'] == 1) {
					echo '<td><span class="badge badge-success px-3 py-1">Confirmed</span></td>';
					echo '<td><a href="appointment-view.php?id=' . encrypt_url($trow['app_id']) . '" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i>View</a></td>';
				} else {
					echo '<td><span class="badge badge-warning px-3 py-1">Pending</span></td>';
					echo '<td></td>';
				}
			?>
		</tr>
	<?php
	}
}