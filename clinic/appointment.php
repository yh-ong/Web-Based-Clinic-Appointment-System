<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');
?><!DOCTYPE html>
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
                            $header = array("Appointment ID #", "Patient", "App Date", "Time", "Treatment Type", "Confirmation", "Action");
                            $arrlen = count($header);
                            for ($i = 0; $i < $arrlen; $i++) {
                                echo "<th>" . $header[$i] . "</th>".PHP_EOL;
                            }
                        }
                        ?>
                        <div class="data-tables">
                            <table id="datatable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <?php headerTable(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $table_result = mysqli_query($conn, "SELECT * FROM doctors WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
                                    while ($table_row = mysqli_fetch_assoc($table_result)) {
                                        ?>
                                    <tr>
                                        <td><?= rand(); ?></td>
                                        <td>Unity Butler</td>
                                        <td>2009/12/09</td>
                                        <td>9:00 AM</td>
                                        <td>Follow Up Visit</td>
                                        <td><span class="badge badge-pill badge-success mr-1">&#10004;</span>Confirmed</td>
                                        <td><button type="button" name="checkbtn" class="btn btn-sm btn-primary"><i class="fas fa-plane-arrival mr-3"></i>Arrive</button></td>
                                    </tr>
                                    <tr>
                                        <td><?= rand(); ?></td>
                                        <td>Howard Hatfield</td>
                                        <td>2008/12/16</td>
                                        <td>10:00 AM</td>
                                        <td>New Patient</td>
                                        <td><span class="badge badge-pill badge-warning mr-1">&#33;</span>Not Confirmed</td>
                                        <td><button type="button" name="checkbtn" class="btn btn-sm btn-primary"><i class="fas fa-walking mr-3"></i>On Way</button></td>
                                    </tr>
                                    <tr>
                                        <td><?= rand(); ?></td>
                                        <td>Hope Fuentes</td>
                                        <td>2010/02/12</td>
                                        <td>12:00 PM</td>
                                        <td>Sick Visit</td>
                                        <td><span class="badge badge-pill badge-success mr-1">&#10004;</span>Confirmed</td>
                                        <td><button type="button" name="checkbtn" class="btn btn-sm btn-primary"><i class="fas fa-walking mr-3"></i>On Way</button></td>
                                    </tr>
                                    <?php } ?>
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
        $( document ).ready(function() {
            $('button[name="checkbtn"]').click(function() {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-successful'); 
                $(this).html('<i class="fas fa-plane-arrival mr-3"></i>Arrive');
            });
        });
    </script>
</body>

</html>