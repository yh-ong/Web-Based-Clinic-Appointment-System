<?php
require_once("includes/dbconnection.php");

include("includes/session.php");
include("includes/config.php");

$pid = $_REQUEST["pid"];
$result = mysqli_query($conn, "SELECT * FROM patients WHERE patient_id = $pid");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes/styles.php'; ?>
</head>
<body>
    <?php include 'includes/navigate.php';?>
    <div class="page-content" id="content">
        <?php include 'includes/header.php';?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- Card Content -->
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <h5 class="card-title mr-auto">View Patient : <?php echo strtoupper($row["patient_name"])?></h5>
                        </div>
                        <div class="card-inner">
                            <!-- View -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-info" role="tab"
                                        aria-controls="nav-home" aria-selected="true">Patient Info</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-history" role="tab"
                                        aria-controls="nav-profile" aria-selected="false">Medication History</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-appointment" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Appointment</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-message" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Message</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="info-tab">
                                    <div class="d-flex align-items-center">
                                        <div class="ml-auto mt-2 mb-2">
                                            <button class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt mr-2"></i>Edit Info</button>
                                        </div>
                                    </div>
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
                                            <td><?php echo $row["patient_name"];?></td>
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
                                <div class="tab-pane fade" id="nav-history" role="tabpanel" aria-labelledby="history-tab">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Medication ID #</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Date Recorded</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>@fat</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Larry</td>
                                                <td>the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-appointment" role="tabpanel" aria-labelledby="appointment-tab">
                                    <div class="d-flex align-items-center">
                                        <div class="ml-auto mt-2 mb-2">
                                            <button class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt mr-2"></i>Edit Appointment</button>
                                            <button class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i>Add Appointment</button>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Medication ID #</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Date Recorded</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Larry</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-message" role="tabpanel" aria-labelledby="message-tab">...</div>
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
    <?php include 'includes/footer.php';?>
</body>
</html>