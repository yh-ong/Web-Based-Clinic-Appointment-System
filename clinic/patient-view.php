<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

$patient_id = $_GET["cid"];
$result = mysqli_query($conn,"SELECT * FROM patients WHERE patient_id = '".$patient_id."' ");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include CSS_PATH; ?>
</head>

<style>
.patient-status-bar .d-flex .flex-fill  {
    border-right: 1px solid #ddd;
    padding: .5rem !important;
    margin: 0 10px 0 0; 
}
.patient-status-bar .d-flex .flex-fill:last-child  {
    border-right: 0;
}


tbody tr td:first-child {
  width: 8em;
  min-width: 10em;
  max-width: 10em;
  word-break: break-all;
}
</style>

<body>
    <?php include NAVIGATION; ?>
    <!-- Page content holder -->
    <div class="page-content" id="content">
        <?php include HEADER; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-md-12">
                <!-- Card Content -->
                <div class="card patient-status-bar">
                    <div class="card-body">
                        <div class="d-flex bd-highlight">
                            <div class="flex-fill bd-highlight">
                                <p class="text-muted">Patient Info</p>
                                <h5 class="font-weight-bold"><?php echo $row["patient_lastname"].' '.$row["patient_firstname"]; ?></h5>
                                <p><?php echo $row["patient_age"]; ?>,&nbsp; <?php echo $row["patient_gender"]; ?> </p>
                            </div>
                            <div class="flex-fill bd-highlight">
                                <p class="text-muted">Last Visit</p>
                                <h5 class="font-weight-bold">21-03-2019</h5>
                            </div>
                            <div class="flex-fill bd-highlight">
                                <p class="text-muted">Diagnosis</p>
                                <h5 class="font-weight-bold">Throat Disease</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h6>Latest Status</h6>
                <div class="card">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="media">
                                <div class="media-body">
                                <div><small class="text-muted">2019-08-12</small></div>
                                <h5 class="mt-0 mb-1">Visit at YH Clinic Centre</h5>
                                Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                </div>
                            </p>
                            <li class="media my-4">
                                <div class="media-body">
                                <div><small class="text-muted">2019-05-27</small></div>
                                <h5 class="mt-0 mb-1">illness</h5>
                                Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h6>Medical History</h6>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Medication ID #</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Date Recorded</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>illness</td>
                                    <td>2019-01-01</td>
                                    <td><button class="btn btn-sm btn-primary">View</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>throat disease</td>
                                    <td>2019-02-01</td>
                                    <td><button class="btn btn-sm btn-primary">View</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>sick</td>
                                    <td>2019-02-04</td>
                                    <td><button class="btn btn-sm btn-primary">View</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Page Content -->
    </div>

    <?php include JS_PATH;?>
</body>

</html>