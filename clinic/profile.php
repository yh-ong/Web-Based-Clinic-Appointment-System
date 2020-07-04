<?php
include('../config/autoload.php');
include('../clinic/includes/path.inc.php');
include('../clinic/includes/session.inc.php');
include('../helper/select_helper.php');
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
                <a href="./profile-edit.php" class="btn btn-primary btn-sm pull-right px-5">Edit Clinic Profile</a>
            </div>

            <div class="col-12">
                <div class="owl-carousel">
                    <?php    
                        $img_result = mysqli_query($conn,"SELECT * FROM clinic_images WHERE clinic_id = ".$clinic_row["clinic_id"]." ");
                        while($img_row = mysqli_fetch_assoc($img_result)) {
                            echo '<div class="item"><img src="../uploads/'.$clinic_row["clinic_id"].'/clinic/'.$img_row["clinicimg_filename"].'"></div>';
                        }
                    ?>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-2 font-weight-bold"><?php echo $clinic_row["clinic_name"]; ?></h5>
                        <p><i class="far fa-envelope fa-fw mr-1"></i><?php echo $clinic_row["clinic_email"] ?></p>
                        <p><i class="fas fa-phone fa-fw mr-1"></i><?php echo $clinic_row["clinic_contact"] ?></p>
                        <p><i class="fas fa-link fa-fw mr-1"></i><?php echo $clinic_row["clinic_url"] ?></p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6><i class="far fa-clock fa-fw mr-1 mb-2"></i>Opening Hours</h6>
                        <?php
                        $hour_result = mysqli_query($conn,"SELECT * FROM business_hour WHERE clinic_id = ".$clinic_row["clinic_id"]." ");
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
                        <p class="mb-2"><i class="fas fa-map-marker-alt fa-fw"></i> <?php echo $clinic_row["clinic_address"].', '.$clinic_row["clinic_state"].', '.$clinic_row["clinic_zipcode"].', '.$clinic_row["clinic_city"] ?></p>
                        <iframe width='100%' height='300' frameborder='0' style='border:0' src='https://www.google.com/maps/embed/v1/place?key=AIzaSyAGx-OjyNn10KsJ_OsE7cl2_qxg6mNBZyI&q="<?= $clinic_row['clinic_address'] ?>+","+<?= $clinic_row['clinic_city'] ?>+","+<?= $clinic_row['clinic_state'] ?>+","+<?= $clinic_row['clinic_zipcode'] ?>+"+Malaysia' allowfullscreen></iframe>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
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
    <script>
        $(function() {
            $('.timepicker').datetimepicker({
                format: 'LT'
            });
        });
    </script>
    <script>
        $('#pillTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        // store the currently selected tab in the hash value
        $(".nav-pills > a").on("shown.bs.tab", function(e) {
            var id = $(e.target).attr("href").substr(1);
            window.location.hash = id;
        });
        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('#pillTab a[href="' + hash + '"]').tab('show');
    </script>
    <script>
        // $('#add').on('click', add);
        // $('#remove').on('click', remove);

        // function add() {
        //     var new_chq_no = parseInt($('#total_chq').val()) + 1;
        //     var new_input = '<div class="form-group row" id=new_"' + new_chq_no + '">\
        //                 <label for="inputBusinessHour" class="col-sm-2 col-form-label">Tuesday</label>\
        //                 <div class="col-sm-2">\
        //                     <input type="text" class="form-control" id="inputBusinessHour">\
        //                 </div>\
        //                 <div class="col-sm-2">\
        //                     <select name="" class="form-control" id="">\
        //                         <option value="am">AM</option>\
        //                         <option value="pm">PM</option>\
        //                     </select>\
        //                 </div>\
        //                 <div class="col-sm-2">\
        //                     <input type="text" class="form-control" id="inputBusinessHour">\
        //                 </div>\
        //                 <div class="col-sm-2">\
        //                     <select name="" class="form-control" id="">\
        //                         <option value="am">AM</option>\
        //                         <option value="pm">PM</option>\
        //                     </select>\
        //                 </div>\
        //             </div>';
        //     $('#new_chq').append(new_input);
        //     $('#total_chq').val(new_chq_no);
        // }

        // function remove() {
        //     var last_chq_no = $('#total_chq').val();
        //     if (last_chq_no > 1) {
        //         $('#new_' + last_chq_no).remove();
        //         $('#total_chq').val(last_chq_no - 1);
        //     }
        // }
    </script>
</body>

</html>
<?php
/**
 * Info Tab
 */
if (isset($_POST["savebtn"])) {
    $clinic_name = mysqli_real_escape_string($conn, $_POST["inputClinicName"]);
    $contact = mysqli_real_escape_string($conn, $_POST["inputContact"]);
    $fax = mysqli_real_escape_string($conn, $_POST["inputFax"]);
    $email = mysqli_real_escape_string($conn, $_POST["inputEmailAddress"]);
    $url = mysqli_real_escape_string($conn, $_POST["inputURL"]);

    $opens = $conn->real_escape_string($_POST["inputOpensHour"]);
    $close = $conn->real_escape_string($_POST["inputCloseHour"]);

    $address = mysqli_real_escape_string($conn, $_POST["inputAddress"]);
    $city = mysqli_real_escape_string($conn, $_POST["inputCity"]);
    if (!empty($_POST['inputState'])) {
        $state = $_POST['inputState'];
    } else {
        $state = "";
    }
    $zipcode = mysqli_real_escape_string($conn, $_POST["inputZipCode"]);

    if (mysqli_query($conn, $query)) {
        echo '<script>
            Swal.fire({ "Great!", "New Record Added!", "success" }).then((result) => {
                if (result.value) { window.location.href = "doctor-add.php"; }
            })
            </script>';
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}

/**
 * Image Tab
 */
if (isset($_POST["uploadbtn"])) {
    $filename = $conn->real_escape_string($_POST["inputImageUpload"]);

    $query = "INSERT INTO clinic_images (clinicimg_filename, clinic_id) VALUES ('" . $filename . "', " . $clinic_row['clinic_id'] . ")";
    if (mysqli_query($conn, $query)) {
        echo '<script>
            Swal.fire({ "Great!", "New Image Added!", "success" }).then((result) => {
                if (result.value) { window.location.href = "clinic.php#tab-images"; }
            })
            </script>';
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>