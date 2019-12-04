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
            <div class="col-12">
                <!-- Card Content -->
                <div class="card">
                    <div class="card-body">
                        <!-- Datatable -->
                        <?php
                        function headerTable()
                        {
                            $header = array("Appointment ID #", "Patient Name", "App Date", "Time",  "Treatment Type", "Status", "Action");
                            for ($i = 0; $i < count($header); $i++) {
                                echo "<th>" . $header[$i] . "</th>".PHP_EOL;
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
                                    $tlist = $conn->query(
                                        "SELECT * FROM appointment 
                                         JOIN patients ON appointment.patient_id = patients.patient_id 
                                         JOIN clinics ON appointment.clinic_id = clinics.clinic_id 
                                         JOIN doctors ON appointment.doctor_id = doctors.doctor_id 
                                         WHERE appointment.doctor_id = " . $doctor_row['doctor_id'] . "
                                        ");
                                    while ($trow = $tlist->fetch_assoc()) :
                                        ?>
                                        <tr>
                                            <td><?= $trow['app_id'] ?></td>
                                            <td><?= $trow['patient_lastname'] . ' ' . $trow['patient_firstname'] ?></td>
                                            <td><?= $trow['app_date'] ?></td>
                                            <td><?= $trow['app_time'] ?></td>
                                            <td><?= $trow['treatment_type'] ?></td>
                                            <?php
                                                if ($trow['status'] == 1) {
                                                    echo '<td><span class="badge badge-success px-3 py-1">Confirmed</span></td>';
                                                    echo '<td><a href="patient-view.php?id='.$trow['patient_id'].'" class="btn btn-sm btn-primary"><i class="fas fa-eye mr-3"></i>View</a></td>';
                                                } else {
                                                    echo '<td><span class="badge badge-warning px-3 py-1">Pending</span></td>';
                                                    echo '<td></td>';
                                                }
                                            ?>
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
                        <!-- End Datatable -->
                    </div>
                </div>
                <!-- End Card Content -->
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
</body>

</html>