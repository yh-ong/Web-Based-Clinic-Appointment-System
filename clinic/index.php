<?php
require_once('../config/autoload.php');
include('includes/path.inc.php');
include('includes/session.inc.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS_PATH; ?>
    <link rel="stylesheet" href="../assets/css/clinic/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
</head>

<body>
    <?php include NAVIGATION; ?>
    <div class="page-content" id="content">
        <?php include HEADER; ?>
        <?php include WIDGET; ?>
        <div class="row">
            <div class="col-12">
                <?php
                if ($clinic_row["clinic_status"] == 0) {
                    echo '<div class="alert alert-danger mt-3" role="alert">
                            Sorry, system administrator under checking your profile, Please Wait until Approve! Thank you using our platform 
                        </div>';
                } else {
                    $doctor_result = mysqli_query($conn, "SELECT * FROM doctors WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
                    $doctor_row = mysqli_fetch_assoc($doctor_result);
                    if (mysqli_num_rows($doctor_result) == 0) {
                        echo '<div class="alert alert-warning mt-3" role="alert">
                                Please Add Doctor <a href="doctor-add.php" class="alert-link">Link to Add Doctor</a>
                            </div>';
                    }
                }
                ?>

                <?php
                $doctor_result = mysqli_query($conn, "SELECT * FROM clinic_images WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
                $doctor_row = mysqli_fetch_assoc($doctor_result);
                if (mysqli_num_rows($doctor_result) == 0) {
                    echo '<div class="alert alert-warning mt-3" role="alert">
                            Please Add Some Image for Clinic <a href="profile-edit.php" class="alert-link">Link to Add Images</a>
                        </div>';
                }
                ?>
                
                <!-- <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Hi, <?php echo $clinic_row["clinic_name"]; ?></h5>
                    </div>
                </div> -->

            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                        <script>
                            Chart.platform.disableCSSInjection = true;
                            var ctx = document.getElementById('myChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                    datasets: [{
                                        label: '# of Appointment',
                                        data: [
                                            <?php
                                            $month_array = array("jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
                                            foreach ($month_array as $key => $month_value) {
                                                $result = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointment WHERE MONTH(app_date) = '" . ++$key . "' AND clinic_id = '" . $clinic_row['clinic_id'] . "' AND consult_status = 1"));
                                                echo "$result,";
                                            }
                                            ?>
                                        ],
                                        fill: false,
                                        borderColor: '#2196f3',
                                        backgroundColor: '#2196f3',
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: 'Monthly Visited Appointment',
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                scaleIntegersOnly: true,
                                                stepSize: 1,
                                                beginAtZero: true,
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <canvas id="HorizontalChart"></canvas>
                        <script>
                            Chart.platform.disableCSSInjection = true;
                            var ctx = document.getElementById('HorizontalChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'horizontalBar',
                                data: {
                                    // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                    labels: [
                                        <?php
                                        $idquery = array();
                                        $result = mysqli_query($conn,"SELECT * FROM doctors WHERE clinic_id = ".$clinic_row['clinic_id']." ");
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '"'.$row['doctor_lastname'].' '.$row['doctor_firstname'].'",';

                                            $idquery[] = $row["doctor_id"];
                                        }
                                        ?>
                                    ],
                                    datasets: [{
                                        label: '# of Appointment',
                                        data: [
                                            <?php
                                            foreach ($idquery as $arrvalue) {
                                                $newsql = "SELECT * FROM appointment WHERE doctor_id = $arrvalue AND consult_status = 1";
                                                $idnum = mysqli_num_rows(mysqli_query($conn,$newsql));
                                                echo $idnum.',';
                                            }
                                            ?>
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: 'Visied Appointment Based on Doctor',
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                    <canvas id="PieChart"></canvas>
                        <script>
                            Chart.platform.disableCSSInjection = true;
                            var ctx = document.getElementById('PieChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                    labels: [
                                        <?php
                                        $idquery = array();
                                        $result = mysqli_query($conn,"SELECT DISTINCT patient_nationality FROM appointment INNER JOIN patients ON appointment.patient_id = patients.patient_id WHERE clinic_id = ".$clinic_row['clinic_id']." ");
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '"'.ucwords($row['patient_nationality']).'",';
                                            $idquery[] = $row["patient_nationality"];
                                        }
                                        ?>
                                    ],
                                    datasets: [{
                                        label: '# of Appointment',
                                        data: [
                                            <?php
                                            foreach ($idquery as $arrvalue) {
                                                $newsql = "SELECT * FROM appointment INNER JOIN patients ON appointment.patient_id = patients.patient_id WHERE patients.patient_nationality = '$arrvalue' AND appointment.consult_status = 1 ";
                                                $idnum = mysqli_num_rows(mysqli_query($conn,$newsql));
                                                echo $idnum.',';
                                            }
                                            ?>
                                        ],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: 'Country Visited Appointment',
                                    },
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php include JS_PATH; ?>
</body>

</html>