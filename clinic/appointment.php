<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');
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
                <div class="card">
                    <div class="card-body">
                        <!-- Datatable -->
                        <?php
                        function headerTable()
                        {
                            $header = array("App ID #", "Patient", "App Date", "Time", "Treatment Type", "Confirmation", "Action");
                            $arrlen = count($header);
                            for ($i = 0; $i < $arrlen; $i++) {
                                echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
                            }
                        }
                        ?>
                        <div class="data-tables table-responsive">
                            <table id="datatable" class="table nowrap" style="width:100%">
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
                                         WHERE appointment.clinic_id = " . $clinic_row['clinic_id'] . "
                                        ");
                                    while ($trow = $tlist->fetch_assoc()) :
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
                                            <td><button type="button" name="checkbtn" class="btn btn-sm btn-primary"><i class="fas fa-plane-arrival mr-3"></i>Arrive</button></td>
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
            </div>
        </div> <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
    <script>
        $(document).ready(function() {
            $('button[name="checkbtn"]').click(function() {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-successful');
                $(this).html('<i class="fas fa-plane-arrival mr-3"></i>Arrive');
            });
        });
    </script>
</body>

</html>