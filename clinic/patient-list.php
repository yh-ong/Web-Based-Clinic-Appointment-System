<?php
include('../config/autoload.php');
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
                <div class="card">
                    <div class="card-body">
                        <!-- Datatable -->
                        <?php
                        function headerTable()
                        {
                            $header = array("Patient ID", "Patient Name", "Contact Number", "Date Added", "Action");
                            $arrlen = count($header);
                            for ($i = 0; $i < $arrlen; $i++) {
                                echo "<th>" . $header[$i] . "</th>" . PHP_EOL;
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
                                    $table_result = mysqli_query($conn, "SELECT * FROM patients");
                                    while ($table_row = mysqli_fetch_assoc($table_result)) {
                                        ?><tr>
                                            <td><?= $table_row["patient_id"]; ?></td>
                                            <td><?= $table_row["patient_lastname"] . ' ' . $table_row["patient_firstname"]; ?></td>
                                            <td><?= $table_row["patient_contact"]; ?></td>
                                            <td><?= $table_row["date_created"]; ?></td>
                                            <td>
                                                <a href="patient-view.php?cid=<?= $table_row["patient_id"]; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                                                <!-- <a href="patient-edit.php?cid=<?= $table_row["patient_id"]; ?>" class="btn btn-sm btn-secondary"><i class="fa fa-pen"></i> Edit</a> -->
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
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
        </div>
        <!-- End Page Content -->
    </div>

    <?php include JS_PATH; ?>
</body>

</html>