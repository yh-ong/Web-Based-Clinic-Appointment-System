<?php
require_once("includes/dbconnection.php");
include("includes/session.php");
include("includes/config.php");

$id = $_REQUEST['cid'];
$decoded_id = base64_decode(urldecode($id));

$result = mysqli_query($conn, "SELECT * FROM clinics WHERE clinic_id = ".$decoded_id."");
$row = mysqli_fetch_assoc($result);
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/styles.php'; ?>
</head>

<body>
    <?php include 'includes/navigate.php'; ?>
    <div class="page-content" id="content">
        <?php include 'includes/header.php'; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- Card Content -->
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <div class="card-inner">
                                <!-- Add Clinic -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputDoctorID">Clinic ID #</label>
                                        <input type="text" name="inputDoctorID" class="form-control" id="inputDoctorID" disabled value="<?php echo $row["clinic_id"];?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputClinicStatus">Clinic Status</label>
                                        <select name="inputClinicStatus" class="form-control" id="inputClinicStatus">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="Approve" <?php if($row["clinic_status"] == 'Approve') echo'selected'?>>Approve</option>
                                            <option value="Not Approve" <?php if($row["clinic_status"] == 'Not Approve') echo'selected'?>>Not Approve</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputClinicName">Clinic Name</label>
                                        <input type="text" name="inputClinicName" class="form-control" id="inputClinicName" placeholder="" value="<?php echo $row["clinic_name"];?>">
                                    </div>
                                </div>
                                <!-- End Add Clinic -->
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <div class="card-inner">
                                <!-- Add Clinic -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputContact">Contact Number</label>
                                        <input type="text" name="inputContact" class="form-control" id="inputContact" placeholder="" value="<?php echo $row["clinic_contact"];?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputFax">Fax Number</label>
                                        <input type="text" name="inputFax" class="form-control" id="inputFax" placeholder="" value="<?php echo $row["clinic_fax"];?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmailAddress">Email Address</label>
                                        <input type="text" name="inputEmailAddress" class="form-control" id="inputEmailAddress" placeholder="example@address.com" value="<?php echo $row["clinic_email"];?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputURL">URL</label>
                                        <input type="text" name="inputURL" class="form-control" id="inputURL" placeholder="www.example.com" value="<?php echo $row["clinic_url"];?>">
                                    </div>
                                </div>
                                <!-- End Add Clinic -->
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <div class="card-inner">
                                <!-- Add Patient -->
                                <div class="form-group">
                                    <label for="inputAddress">Address</label>
                                    <input type="text" name="inputAddress" class="form-control" id="inputAddress" placeholder="1234 Main St" value="<?php echo $row["clinic_address"];?>">
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Address 2</label>
                                    <input type="text" name="inputAddress2" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCity">City</label>
                                        <input type="text" name="inputCity" class="form-control" id="inputCity" value="<?php echo $row["clinic_city"];?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState">State</label>
                                        <select name="inputState" id="inputState" class="form-control selectpicker" data-live-search="true">
                                            <option value="" selected disabled>Choose</option>
                                            <?php foreach ($select_state as $state_value) {
                                                if($row["clinic_state"] == "$state_value") {
                                                    $selected = "selected";
                                                } else {
                                                    $selected = "";
                                                }
                                                echo '<option value="'.$state_value.'"'.$selected.'>'.$state_value.'</option>';

                                                    
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZipCode">Zip Code</label>
                                        <input type="text" name="inputZipCode" class="form-control" id="inputZipCode" value="<?php echo $row["clinic_zipcode"];?>">
                                    </div>
                                </div>
                                <!-- End Add Patient -->
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="savebtn">Add Clinic</button>
                    </div>
                </form>
                <!-- End Card Content -->
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include 'includes/footer.php'; ?>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
</body>

</html>
<?php
if (isset($_POST["savebtn"])) {
    if (!empty($_POST['inputClinicStatus'])) {
        $status = $_POST['inputClinicStatus'];
    } else {
        $status = "Not Approve";
    }
    $clinic_name = mysqli_real_escape_string($conn, $_POST["inputClinicName"]);
    $contact = mysqli_real_escape_string($conn, $_POST["inputContact"]);
    $fax = mysqli_real_escape_string($conn, $_POST["inputFax"]);
    $email = mysqli_real_escape_string($conn, $_POST["inputEmailAddress"]);
    $url = mysqli_real_escape_string($conn, $_POST["inputURL"]);

    $address = mysqli_real_escape_string($conn, $_POST["inputAddress"]) . ' ' . mysqli_real_escape_string($conn, $_POST["inputAddress2"]);
    $city = mysqli_real_escape_string($conn, $_POST["inputCity"]);

    if (!empty($_POST['inputState'])) {
        $state = $_POST['inputState'];
    } else {
        $state = "";
    }
    $zipcode = mysqli_real_escape_string($conn, $_POST["inputZipCode"]);

    $result = mysqli_query($conn,"SELECT * FROM patients WHERE patient_email = '.$email.'");
    if (mysqli_num_rows($result) != 0) {
        echo '<script>alert("Email Already Existed");</script>';
        exit();
    } else if (empty($clinic_name) && empty($contact) && empty($email) && empty($address)) {
        echo '<script>alert("Cannot Be Empty");</script>';
        exit();
    } else {
        try {
            $sql = 'INSERT INTO clinics 
                    (clinic_name, clinic_email, clinic_url, clinic_contact, clinic_fax, clinic_address, clinic_city, clinic_state, clinic_zipcode, clinic_status, date_created)
                    VALUES ("'.$clinic_name.'", "'.$email.'", "'.$url.'", "'.$contact.'", "'.$fax.'", "'.$address.'", "'.$city.'", "'.$state.'", "'.$zipcode.'", "'.$status.'", "'.$date_created.'")';
            mysqli_query($conn,$sql);
            echo '<script>alert("New record created successfully");s</script>';
            header("Location: clinic-add.php");
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
        mysqli_close($conn);
    }
    ob_end_flush();
}
?>