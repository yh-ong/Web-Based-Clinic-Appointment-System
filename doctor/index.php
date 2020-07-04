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
        <!-- Page content -->
        <?php include WIDGET; ?>
        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                        <script>
                            Chart.platform.disableCSSInjection = true;
                            var ctx = document.getElementById('myChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                    datasets: [{
                                        label: '# of Appointment',
                                        // data: [12, 19, 3, 5, 2, 3],
                                        data: [
                                            <?php
                                            $month_array = array("jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
                                            foreach ($month_array as $key => $month_value) {
                                                $result = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointment WHERE MONTH(app_date) = '" . ++$key . "' AND doctor_id = '" . $doctor_row['doctor_id'] . "' AND consult_status = 1 "));
                                                echo "$result,";
                                            }
                                            ?>
                                        ],
                                        backgroundColor: [
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: "Visited Appointment"
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                scaleIntegersOnly: true,
                                                stepSize: 1,
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
                    <canvas id="BarChart"></canvas>
                        <script>
                            Chart.platform.disableCSSInjection = true;
                            var ctx = document.getElementById('BarChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                    labels: [
                                        <?php
                                        $idquery = array();
                                        $result = mysqli_query($conn,"SELECT DISTINCT patient_nationality FROM appointment INNER JOIN patients ON appointment.patient_id = patients.patient_id WHERE doctor_id = ".$doctor_row['doctor_id']." ");
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
                                        text: 'Appointment Visited Based on Country',
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
                    <canvas id="LineChart"></canvas>
                        <script>
                            Chart.platform.disableCSSInjection = true;
                            var ctx = document.getElementById('LineChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                    labels: [
                                        <?php
                                        $idquery = array();
                                        $result = mysqli_query($conn,"SELECT DISTINCT app_time FROM appointment WHERE doctor_id = ".$doctor_row['doctor_id']." ORDER BY app_time DESC");
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '"'.$row['app_time'].'",';
                                            $idquery[] = $row["app_time"];
                                        }
                                        ?>
                                    ],
                                    datasets: [{
                                        label: '# of Appointment',
                                        data: [
                                            <?php
                                            foreach ($idquery as $arrvalue) {
                                                $newsql = "SELECT * FROM appointment WHERE app_time = '$arrvalue' AND consult_status = 1 ";
                                                $idnum = mysqli_num_rows(mysqli_query($conn,$newsql));
                                                echo $idnum.',';
                                            }
                                            ?>
                                        ],
                                        fill: false,
                                        borderColor: 'rgba(255, 206, 86, 1)',
                                        backgroundColor: 'rgba(255, 206, 86, 1)',
                                        borderWidth: 3
                                    }]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: 'Visited Appointment Time Analytic',
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
            
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
</body>

</html>