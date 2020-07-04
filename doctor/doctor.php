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
            <div class="col-12 mt-3 mb-3">
                <a href="./doctor-edit.php" class="btn btn-primary btn-sm pull-right px-5">Edit Profile</a>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if ($doctor_row["doctor_avatar"] != "") {
                            echo '<img src="../uploads/' . $doctor_row["clinic_id"] . '/doctor'. '/' . $doctor_row["doctor_avatar"] . '" id="output" class="img-fluid thumbnail" alt="Doctor-Avatar" title="Doctor-Avatar">';
                        } else {
                            echo '<img src="./img/empty-avatar.jpg" id="output" class="img-fluid thumbnail" alt="Doctor-Avatar" title="Doctor-Avatar">';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-2">Dr. <?php echo $doctor_row["doctor_lastname"] . ' ' . $doctor_row["doctor_firstname"]; ?></h5>
                        <h6>
                            <?php
                            $table_result = mysqli_query($conn, "SELECT * FROM speciality WHERE speciality_id =  '".$doctor_row["doctor_speciality"]."' ");
                            while ($table_row = mysqli_fetch_assoc($table_result)) {
                                echo $table_row['speciality_name'];
                            }
                            ?>
                        </h6>
                    </div>
                </div>
                <div class="mt-3">
                    <h5>About Me</h5>
                    <div class="card">
                        <div class="card-body">
                            <p><i class="fas fa-vote-yea fa-fw mr-3"></i><?= $doctor_row["doctor_experience"]; ?> Yrs Exp</p>
                            <p><i class="fas fa-phone-alt fa-fw mr-3"></i><?= $doctor_row["doctor_contact"]; ?></p>
                            <p><i class="far fa-envelope fa-fw mr-3"></i><?= $doctor_row["doctor_email"]; ?></p>
                            <p><i class="far fa-calendar fa-fw mr-3"></i><?= $doctor_row["doctor_dob"]; ?></p>
                            <p><i class="fas fa-venus-mars fa-fw mr-3"></i><?= $doctor_row["doctor_gender"]; ?></p>
                            <p><i class="fas fa-language fa-fw mr-3"></i><?= $doctor_row["doctor_spoke"]; ?></p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <p><?= $doctor_row["doctor_desc"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
</body>

</html>