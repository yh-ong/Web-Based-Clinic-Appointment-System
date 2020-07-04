<?php
include('../config/autoload.php');

$date = $_POST['date'];
$id = $_POST['id'];

$query = "SELECT * FROM appointment, patients, clinics WHERE
appointment.patient_id = patients.patient_id AND
appointment.clinic_id = clinics.clinic_id AND
appointment.clinic_id = $id AND appointment.app_date = '$date' AND appointment.status = 1
ORDER BY SUBSTRING_INDEX(appointment.app_time, ' ', -1), SUBSTRING_INDEX(appointment.app_time, ' ', 1)
";

// $query = "SELECT * FROM appointment 
// JOIN patients ON appointment.patient_id = patients.patient_id 
// JOIN clinics ON appointment.clinic_id = clinics.clinic_id 
// JOIN doctors ON appointment.doctor_id = doctors.doctor_id 
// WHERE appointment.clinic_id = " . $id . " 
// ";
$tlist = $conn->query($query);

while ($trow = $tlist->fetch_assoc()) {
    if ($tlist->num_rows < 1) {
        echo '<tr><td>No Appointment</td></tr>';
    } else {
    ?>
    <tr>
        <td><?= $trow['app_id'] ?></td>
        <td><?= $trow['patient_lastname'] . ' ' . $trow['patient_firstname'] ?></td>
        <td><?= $trow['app_date'] ?></td>
        <td><?= $trow['app_time'] ?></td>
        <td><?= $trow['treatment_type'] ?></td>
        <td><?php
            if ($trow['status'] == 1) {
                echo '<span class="badge badge-success px-3 py-1">Confirmed</span>';
            } else {
                echo '<span class="badge badge-warning px-3 py-1">Pending</span>';
            }
            ?>
        </td>
        <td>
            <?php
            if ($trow['arrive_status'] == 1) {
                echo '<button type="button" name="checkbtn" class="btn btn-sm btn-secondary" disabled><i class="fas fa-chair mr-3"></i>Seated</button>';
            } else {
                echo '<button type="button" name="checkbtn" class="btn btn-sm btn-primary" onclick="updateId(' . $trow['app_id'] . ')"><i class="fas fa-plane-arrival mr-3"></i>Arrive</button>';
            }
            ?>
        </td>
    </tr>
<?php
    }
}
?>