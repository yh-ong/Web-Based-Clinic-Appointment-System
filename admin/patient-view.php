<?php
require_once("../config/autoload.php");
include("includes/session.inc.php");
include("includes/path.inc.php");

$pid = decrypt_url($_REQUEST["pid"]);
$result = mysqli_query($conn, "SELECT * FROM patients WHERE patient_id = $pid");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include CSS_PATH; ?>
</head>
<body>
    <?php include NAVIGATION;?>
    <div class="page-content" id="content">
        <?php include HEADER;?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- Card Content -->
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <h5 class="card-title mr-auto">View Patient : <?php echo strtoupper($row["patient_firstname"].' '.$row["patient_lastname"])?></h5>
                        </div>
                        <div class="card-inner">
                            <!-- View -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-info" role="tab"
                                        aria-controls="nav-home" aria-selected="true">Patient Info</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-appointment" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Appointment</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="info-tab">
                                    <table class="table table-bordered">
                                        <?php if (mysqli_num_rows($result) < 1) {
                                            echo '<tr><td class="text-center">No Member Record!</td></tr>';
                                        } else {
                                        ?>
                                        <tr>
                                            <th scope="row">Patient ID</th>
                                            <td><?php echo $row["patient_id"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Name</th>
                                            <td><?php echo $row["patient_firstname"].' '.$row["patient_lastname"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Identity</th>
                                            <td><?php echo $row["patient_identity"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Gender</th>
                                            <td><?php echo $row["patient_gender"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Marital Status</th>
                                            <td><?php echo $row["patient_maritalstatus"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Email</th>
                                            <td><?php echo $row["patient_email"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Contact</th>
                                            <td><?php echo $row["patient_contact"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Nationality</th>
                                            <td><?php echo $row["patient_nationality"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Date of Birth</th>
                                            <td><?php echo $row["patient_dob"];?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td><?php echo $row["patient_address"].' '.$row["patient_zipcode"].' '.$row["patient_city"].' '.$row["patient_state"]?></td>
                                        </tr>
                                        <?php
                                        } ?>
                                    </table>
                                </div>
                                
                                <div class="tab-pane fade" id="nav-appointment" role="tabpanel" aria-labelledby="appointment-tab">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date #</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Doctor Name</th>
                                                <th scope="col">Treatment Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM appointment JOIN doctors ON appointment.doctor_id = doctors.doctor_id WHERE patient_id = '".$pid."'");
                                            while($row = mysqli_fetch_assoc($result)) {
                                                if ($result->num_rows == 0) {
                                                    echo '<p>No result</p>';
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td><?= $row["app_date"] ?></td>
                                                        <td><?= $row["app_time"] ?></td>
                                                        <td>Dr. <?= $row["doctor_firstname"].' '.$row["doctor_lastname"] ?></td>
                                                        <td><?= $row["treatment_type"] ?></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                }
                                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End View -->
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