<?php
require_once("../config/autoload.php");
include("includes/session.inc.php");
include("includes/path.inc.php");

$sql = "SELECT * FROM clinics WHERE clinic_id = ?";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include CSS_PATH;?>
</head>

<body>
    <?php include NAVIGATION; ?>
    <div class="page-content" id="content">
        <?php include HEADER;?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- Card Content -->
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <div class="card-inner">
                            <!-- Datatable -->
                            <div class="data-tables">
                                <table id="datatable" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Patient ID #</th>
                                            <th>Patient Name</th>
                                            <th>Date of Birth</th>
                                            <th>Phone Number</th>
                                            <th>Date Added</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $table_result = mysqli_query($conn, "SELECT * FROM patients");
                                        while ($table_row = mysqli_fetch_assoc($table_result)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $table_row["patient_id"];?></td>
                                            <td><?php echo $table_row["patient_lastname"].' '.$table_row["patient_firstname"];?></td>
                                            <td><?php echo $table_row["patient_dob"];?></td>
                                            <td><?php echo $table_row["patient_contact"];?></td>
                                            <td><?php echo $table_row["date_created"];?></td>
                                            <td><a href="patient-view.php?pid=<?php echo encrypt_url($table_row["patient_id"]);?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Patient ID #</th>
                                            <th>Patient Name</th>
                                            <th>Date of Birth</th>
                                            <th>Phone Number</th>
                                            <th>Date Added</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- End Datatable -->
                        </div>
                    </div>
                </div>
                <!-- End Card Content -->
            </div>
        </div>
        <!-- End Page Content -->
    </div>

    <?php include JS_PATH;?>
</body>
</html>