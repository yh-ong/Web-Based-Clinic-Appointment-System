<?php
require_once('../config/autoload.php');
include('includes/path.inc.php');
include('includes/session.inc.php');

// Security ENCRYPT URL
$id = $_REQUEST['cid'];
$decoded_id = base64_decode(urldecode($id));

$result = mysqli_query($conn, "SELECT * FROM clinics WHERE clinic_id = $decoded_id");
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include CSS_PATH; ?>
</head>
<body>
    <?php include NAVIGATION;?>
    <div class="page-content" id="content">
        <?php include HEADER;?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12 mt-3 mb-3">
                <a href="./clinic-edit.php" class="btn btn-primary btn-sm pull-right px-5" data-toggle="modal" data-target="#exampleModal">Approve</a>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                       <form method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $row["clinic_name"]; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="inputClinic" value="<?= $row["clinic_id"] ?>">
                                    <p>Do you approve <?php echo $row["clinic_name"]; ?> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="approvebtn" class="btn btn-primary">Approve</button>
                                </div>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="owl-carousel">
                    <?php
                        $img_result = mysqli_query($conn,"SELECT * FROM clinic_images WHERE clinic_id = ".$row["clinic_id"]." ");
                        while($img_row = mysqli_fetch_assoc($img_result)) {
                            echo '<div class="item"><img src="../uploads/'.$row["clinic_id"].'/clinic/'.$img_row["clinicimg_filename"].'"></div>';
                        }
                    ?>
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
                            <p class="col-xs-2"><span class="badge badge-info px-3 py-1">Monday - Friday</span></p>
                            <p class="col-xs-8">
                                <?php if($hour_row["open_week"] == "" && $hour_row["close_week"] == "") {
                                    echo "Closed";
                                } else {
                                    echo $hour_row['open_week'].' -- '.$hour_row['close_week'];
                                }
                                ?>
                            </p>
                            <p class="col-xs-2"><span class="badge badge-info px-3 py-1">Saturday</span></p>
                            <p class="col-xs-8">
                                <?php if($hour_row["open_sat"] == "" && $hour_row["close_sat"] == "") {
                                    echo "Closed";
                                } else {
                                    echo $hour_row['open_sat'].' -- '.$hour_row['close_sat'];
                                }
                                ?>
                            </p>
                            <p class="col-xs-2"><span class="badge badge-info px-3 py-1">Sunday</span></p>
                            <p class="col-xs-8">
                                <?php if($hour_row["open_sun"] == "" && $hour_row["close_sun"] == "") {
                                    echo "Closed";
                                } else {
                                    echo $hour_row['open_sun'].' -- '.$hour_row['close_sun'];
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
                    <p class="mb-2"><i class="fas fa-map-marker-alt fa-fw"></i> <?php echo $row["clinic_address"].', '.$row["clinic_state"].', '.$row["clinic_zipcode"].', '.$row["clinic_city"] ?></p>
                        <iframe width='100%' height='300' frameborder='0' style='border:0' src='https://www.google.com/maps/embed/v1/place?key=AIzaSyAGx-OjyNn10KsJ_OsE7cl2_qxg6mNBZyI&q="<?= $row['clinic_address'] ?>+","+<?= $row['clinic_city'] ?>+","+<?= $row['clinic_state'] ?>+","+<?= $row['clinic_zipcode'] ?>+"+Malaysia' allowfullscreen></iframe>
                    </div>
                </div>
            </div>

        </div>

        <!-- End Page Content -->
    </div>
    <?php include JS_PATH;?>
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
<?php
if (isset($_POST['approvebtn'])) {
    $status = 1;
    $clinic_id = escape_input($_POST['inputClinic']);
    $appstmt = $conn->prepare("UPDATE clinics SET clinic_status = ? WHERE clinic_id = ?");
    $appstmt->bind_param("ss", $status, $clinic_id);
    if ($appstmt->execute()) {
        echo '<script>
                Swal.fire({ title: "Great!", text: "New Record Added!", type: "success" }).then((result) => {
                    if (result.value) { window.location.href = "clinic-list.php"; }
                });
                </script>';
    } else {
        echo 'Something Wrong';
    }
}
?>