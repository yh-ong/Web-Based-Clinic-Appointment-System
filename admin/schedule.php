<?php include("dbconnection.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $PAGE_TITLE;?></title>
    <?php include 'includes/styles.php';?>
</head>
<body>
    <?php include 'includes/navigate.php';?>
    <!-- Page content holder -->
    <div class="page-content" id="content">
        <?php include 'includes/header.php'; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- Card Content -->
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <h5 class="card-title">Appointment</h5>
                        
                    </div>
                </div>
                <!-- End Card Content -->
            </div>
        </div>
        <!-- End Page Content -->
        <?php include 'includes/footer.php';?>
    </div>
    <?php include 'includes/script.php';?>
</body>
</html>