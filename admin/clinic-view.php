<?php
require_once("includes/dbconnection.php");

include("includes/session.php");
include("includes/config.php");

// Security ENCRYPT URL
$id = $_REQUEST['cid'];
$decoded_id = base64_decode(urldecode($id));

$result = mysqli_query($conn, "SELECT * FROM clinics WHERE clinic_id = $decoded_id");
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
            <div class="col-12 mt-3 mb-3">
                <a href="./clinic-edit.php" class="btn btn-primary btn-sm pull-right px-5" data-toggle="modal" data-target="#exampleModal">Approve</a>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><?php echo $row["clinic_name"]; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Do you approve <?php echo $row["clinic_name"]; ?> ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-primary">Approve</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="owl-carousel">
                    <div class="item"><img src="../uploads/clinicimg/clinicimg1.jpg"></div>
                    <div class="item"><img src="../uploads/clinicimg/clinicimg2.jpg"></div>
                    <div class="item"><img src="../uploads/clinicimg/clinicimg3.jpg"></div>
                    <div class="item"><img src="../uploads/clinicimg/clinicimg4.jpg"></div>
                    <div class="item"><img src="../uploads/clinicimg/clinicimg5.jpg"></div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-2 font-weight-bold"><?php echo $row["clinic_name"]; ?></h5>
                        <p><i class="far fa-envelope fa-fw mr-1"></i><?php echo $row["clinic_email"] ?></p>
                        <p><i class="fas fa-phone fa-fw mr-1"></i><?php echo $row["clinic_contact"] ?></p>
                        <p><i class="fas fa-link fa-fw mr-1"></i><?php echo $row["clinic_url"] ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6><i class="far fa-clock fa-fw mr-1 mb-2"></i>Opening Hours</h6>
                        <?php
                        $hour_result = mysqli_query($conn,"SELECT * FROM business_hour WHERE clinic_id = ".$row["clinic_id"]." ");
                        while ($hour_row = mysqli_fetch_assoc($hour_result)) {
                            ?>
                            <p class="col-xs-2"><span class="badge badge-info px-3 py-1"><?=$hour_row["day"]?></span></p>
                            <p class="col-xs-8">
                                <?php if($hour_row["open"] == "" && $hour_row["close"] == "") {
                                    echo "Closed";
                                } else {
                                    echo $hour_row['open'].' -- '.$hour_row['close'];
                                }
                                ?>
                            </p>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <p class="mb-2"><i class="fas fa-map-marker-alt fa-fw"></i> <?php echo $row["clinic_address"].' '.$row["clinic_city"].' '.$row["clinic_state"].' '.$row["clinic_zipcode"] ?></p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d8149819.804819931!2d109.61814849999999!3d4.1406339999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smy!4v1569765236872!5m2!1sen!2smy" width="100%" height="320" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                </div>
            </div>

        </div>

        <!-- End Page Content -->
    </div>
    <?php include 'includes/footer.php';?>
    <script>
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            margin:10,
            loop:true,
            autoplay:true,
            autoplayTimeout:1000,
            autoplayHoverPause:true
        });
    });
    </script>
</body>
</html>