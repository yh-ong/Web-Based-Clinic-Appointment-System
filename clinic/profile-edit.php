<?php
require_once('../config/autoload.php');
include('includes/path.inc.php');
include('includes/session.inc.php');
include(SELECT_HELPER);
?><!DOCTYPE html>
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
            <div class="col-12">
                <div class="nav nav-pills nav-justified mt-3" id="pillTab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="pill" href="#tab-home" role="tab">Details</a>
                    <a class="nav-item nav-link" id="nav-image-tab" data-toggle="pill" href="#tab-images" role="tab">Images</a>
                </div>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-home">
                        <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputDoctorID">Clinic ID #</label>
                                            <input type="text" name="inputClinicID" class="form-control" id="inputClinicID" disabled value="<?php echo $clinic_row["clinic_id"]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputClinicName">Clinic Name</label>
                                            <input type="text" name="inputClinicName" class="form-control" id="inputClinicName" placeholder="" value="<?php echo $clinic_row["clinic_name"]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputContact">Contact Number</label>
                                            <input type="text" name="inputContact" class="form-control" id="inputContact" placeholder="" value="<?php echo $clinic_row["clinic_contact"]; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmailAddress">Email Address</label>
                                            <input type="text" name="inputEmailAddress" class="form-control" id="inputEmailAddress" placeholder="example@address.com" value="<?php echo $clinic_row["clinic_email"]; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputURL">URL</label>
                                            <input type="text" name="inputURL" class="form-control" id="inputURL" placeholder="www.example.com" value="<?php echo $clinic_row["clinic_url"]; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <span class="card-title">Business Hour</span>
                                    <div class="mb-2">
                                        <small class="text-muted">When you're closed on a certain day, just leave the hours blank.</small>
                                        <small class="text-muted">Remember: 12PM is midday, 12AM is midnight</small>
                                    </div>
                                    <?php
                                    $week_row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM business_hour WHERE clinic_id = ".$clinic_row["clinic_id"]." AND day='Monday - Friday';"));
                                    $sat_row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM business_hour WHERE clinic_id = ".$clinic_row["clinic_id"]." AND day='Saturday';"));
                                    $sun_row = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM business_hour WHERE clinic_id = ".$clinic_row["clinic_id"]." AND day='Sunday';"));
                                    ?>
                                    <div class="form-group row">
                                        <label for="inputBusinessHourWeek" class="col-sm-2 col-form-label">Monday - Friday</label>
                                        <div class="col-sm-2">
                                            <select name="" class="form-control form-control-sm" id="">
                                                <option value="">Select</option>
                                                <option value="open">Open</option>
                                                <option value="close">Close</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm timepicker" name="inputOpensHourWeek" value="<?=$week_row["open"];?>">
                                        </div><span>--</span>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm timepicker" name="inputCloseHourWeek" value="<?=$week_row["close"];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputBusinessHourSat" class="col-sm-2 col-form-label">Saturday</label>
                                        <div class="col-sm-2">
                                            <select name="" class="form-control form-control-sm" id="">
                                                <option value="">Select</option>
                                                <option value="open">Open</option>
                                                <option value="close">Close</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm timepicker" name="inputOpensHourSat" value="<?=$sat_row["open"];?>">
                                        </div><span>--</span>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm timepicker" name="inputCloseHourSat" value="<?=$sat_row["close"];?>">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputBusinessHourSun" class="col-sm-2 col-form-label">Sunday</label>
                                        <div class="col-sm-2">
                                            <select name="" class="form-control form-control-sm" id="">
                                                <option value="">Select</option>
                                                <option value="open">Open</option>
                                                <option value="close">Close</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm timepicker" name="inputOpensHourSun" value="<?=$sun_row["open"];?>">
                                        </div><span>--</span>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm timepicker" name="inputCloseHourSun" value="<?=$sun_row["close"];?>">
                                        </div>
                                    </div>
                                    <!-- <div id="new_chq"></div>
                                    <input type="hidden" value="1" id="total_chq">
                                    <div class="d-flelx">
                                        <button type="button" class="btn btn-primary" id="add">Add</button>
                                        <button type="button" class="btn btn-primary" id="remove">Remove</button>
                                    </div> -->
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputAddress">Address</label>
                                        <input type="text" name="inputAddress" class="form-control" id="inputAddress" placeholder="1234 Main St" value="<?php echo $clinic_row["clinic_address"]; ?>">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputCity">City</label>
                                            <input type="text" name="inputCity" class="form-control" id="inputCity" value="<?php echo $clinic_row["clinic_city"]; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputState">State</label>
                                            <select name="inputState" id="inputState" class="form-control selectpicker" data-live-search="true">
                                                <option value="" selected disabled>Choose</option>
                                                <?php foreach ($select_state as $state_value) {
                                                    if ($clinic_row["clinic_state"] == "$state_value") {
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                    echo '<option value="' . $state_value . '"' . $selected . '>' . $state_value . '</option>';
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputZipCode">Zip Code</label>
                                            <input type="text" name="inputZipCode" class="form-control" id="inputZipCode" value="<?php echo $clinic_row["clinic_zipcode"]; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 mt-3">
                                <button type="submit" class="btn btn-primary btn-block" name="savebtn">Save</button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="tab-images">
                        <form name="imgform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" name="inputImageUpload" class="custom-file-input" id="inputImageUpload" aria-describedby="inputGroupFileImage" multiple>
                                            <label class="custom-file-label" for="inputImageUpload">Choose file</label>
                                        </div>
                                        <div class="input-group-prepend">
                                            <button type="submit" name="uploadbtn" class="btn btn-primary btn-sm px-4" id="inputGroupFileImage">Upload</button>
                                        </div>
                                    </div>

                                    <div class="row">
                                    <?php
                                    $table_result = mysqli_query($conn, "SELECT * FROM clinic_images WHERE clinic_id = " . $clinic_row['clinic_id'] . "");
                                    $count = mysqli_num_rows($table_result);
                                    if ($count == 0) {
                                        echo '<div class="col mt-2">
                                        <div class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                                        <h6 class="mt-2">No Image Available</h6>
                                        </div></div>';
                                    } else {
                                        while ($table_row = mysqli_fetch_assoc($table_result)) {
                                    echo '<div class="col-sm-3">
                                            <img src="./img/empty-image.png" class="img-thumbnail" width="300px" alt="">
                                        </div>';
                                        }
                                    }
                                    ?>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div> <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
    <script>
        $(function () {
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