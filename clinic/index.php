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
                $doctor_result = mysqli_query($conn, "SELECT * FROM doctors WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
                $doctor_row = mysqli_fetch_assoc($doctor_result);
                if (mysqli_num_rows($doctor_result) == 0) {
                    echo '<div class="alert alert-warning mt-3" role="alert">
                            Please Add Doctor <a href="doctor-add.php" class="alert-link">Add Doctor Page</a>
                        </div>';
                }
                ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Hi, <?php echo $clinic_row["clinic_name"]; ?></h5>
                        <p class="card-text">We are here to serve you.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                        <script>
                            Chart.platform.disableCSSInjection = true;
                            var ctx = document.getElementById('myChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                                    datasets: [{
                                        label: '# of Votes',
                                        data: [12, 19, 3, 5, 2, 3],
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
    </div>
    <?php include JS_PATH; ?>
</body>

</html>