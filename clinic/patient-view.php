<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

$patient_id = decrypt_url($_GET["cid"]);
$result = mysqli_query($conn,"SELECT * FROM patients WHERE patient_id = '".$patient_id."' ");
$row = mysqli_fetch_assoc($result);

$dobDate = date('d-m-Y', strtotime($row["patient_dob"]));
$dobDate = explode("-", $dobDate);
$age = (date("md", date("U", mktime(0, 0, 0, $dobDate[0], $dobDate[1], $dobDate[2]))) > date("md")
    ? ((date("Y") - $dobDate[2]) - 1)
    : (date("Y") - $dobDate[2]));


$medresult = $conn->query(
    "SELECT * FROM medical_record M 
    INNER JOIN patients P ON M.patient_id = P.patient_id
    WHERE M.patient_id = $patient_id AND M.clinic_id = '".$clinic_row["clinic_id"]."' ORDER BY M.med_id DESC "
);
$barrow = $medresult->fetch_assoc();
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
                                <p><?php echo $age; ?>,&nbsp; <?php echo $row["patient_gender"]; ?> </p>
                            </div>
                            <div class="flex-fill bd-highlight">
                                <p class="text-muted">Last Visit</p>
                                <h5 class="font-weight-bold">
									<?php if ($medresult->num_rows == 0) {
										echo 'New Patient';
									} else {
										echo date_format(new DateTime($barrow['med_date']), 'Y-m-d');
									}
									?>
								</h5>
                            </div>
                            <div class="flex-fill bd-highlight">
                                <p class="text-muted">Diagnosis</p>
                                <h5 class="font-weight-bold">
									<?php if ($medresult->num_rows == 0) {
										echo 'New Patient';
									} else {
										echo $barrow['med_diagnosis'];
									}
									?>
								</h5>
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
                        <?php
                        $medresult2 = $conn->query(
                            "SELECT * FROM medical_record M 
                            INNER JOIN patients P ON M.patient_id = P.patient_id
                            WHERE M.patient_id = $patient_id AND M.clinic_id = '".$clinic_row["clinic_id"]."' ORDER BY M.med_id DESC "
                        );
                        if ($medresult2->num_rows == 0) {
                            echo '<td colspan="4">No Record Found</td>';
                        } else {
                            while ($medrow = $medresult2->fetch_assoc()) {
                            ?>
                                <li class="media my-2">
                                    <div class="media-body">
                                    <div><small class="text-muted"><?= $medrow["med_date"] ?></small></div>
                                    <h6 class="mt-0 mb-1"><?= $medrow["med_diagnosis"] ?></h6>
                                    <?= $medrow["med_sympton"] ?>
                                    </div>
                                </li>
                            <?php
                            }
                        }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <h6>Appointment List</h6>
                <div class="card">
                    <div class="card-body">
                        <table class="table nowrap">
                            <thead>
                                <th>Date</th>
                                <th>Treatment</th>
                            </thead>
                            <tbody>
                                <?php
                                $tresult = $conn->query("SELECT * FROM appointment WHERE patient_id = $patient_id");
                                if ($tresult->num_rows == 0) {
                                    echo '<td colspan="2">No Record Found</td>';
                                } else {
                                    while ($trow = $tresult->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $trow['app_date'] ?></td>
                                            <td><?= $trow['treatment_type'] ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
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