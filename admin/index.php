<?php
require_once('../config/autoload.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS_PATH; ?>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <?php include 'includes/navigate.php';?>
    <div class="page-content" id="content">
        <?php include 'includes/header.php';?>
        <!-- Page content -->
        <?php include 'layouts/widget.php';?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6>
                            <i class="far fa-clock"></i> <?php echo date('Y-m-d');?> <span id="timer"></span>
                            <script>
                                setInterval(function() {
                                    var currentTime = new Date();
                                    var currentHours = currentTime.getHours();
                                    var currentMinutes = currentTime.getMinutes();
                                    var currentSeconds = currentTime.getSeconds();
                                    currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
                                    currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
                                    var timeOfDay = (currentHours < 12) ? "AM" : "PM";
                                    currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;
                                    currentHours = (currentHours == 0) ? 12 : currentHours;
                                    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
                                    document.getElementById("timer").innerHTML = currentTimeString;
                                }, 1000);
                            </script>
                        </h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Appointment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
</body>
</html>