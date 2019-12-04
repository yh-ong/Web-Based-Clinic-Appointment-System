<?php
$nameError = $emailError = $contactError = $urlError = $addressError = $stateError = $zipcodeError = "";
$nameErrorClass = $emailErrorClass = $contactErrorClass = $urlErrorClass = $addressErrorClass = $stateErrorClass = $zipcodeErrorClass = "";

if (isset($_POST["savebtn"])) {

    if (empty($_POST["inputClinicName"])) {
        $nameError = "Clinic Name is required";
        $nameErrorClass = " is-invalid";
    } else {
        $name = test_input($_POST["inputClinicName"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameError = "Only letter and white space allowed";
            $nameErrorClass = " is-invalid";
        }
    }

    if (empty($_POST["inputEmailAddress"])) {
        $emailError = "Email Address is required";
        $emailErrorClass = " is-invalid";
    } else {
        $email = test_input($_POST["inputEmailAddress"]);
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
            $emailError = " * Please enter your email address in format: example@address.com";
            $emailErrorClass = " is-invalid";
        }
    }

    if (!empty($_POST["inputURL"])) {
        $url = test_input($_POST["inputURL"]);
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$url)) {
            $urlError = " * Please enter valid address in format: www.example.com";
            $urltErrorClass = " is-invalid";
        }
    }

    if (empty($_POST["inputContact"])) {
        $contactError = "Contact Number is required.";
        $contactErrorClass = " is-invalid";
    } else {
        $contact = test_input($_POST["inputContact"]);
        if (!preg_match_all("/^(\+|\d)[0-9]{7,13}$/", $contact)) {
            $contactError = "Please enter a valid Country Code (+91xxxxxxxxxx)";
            $contactErrorClass = " is-invalid";
        }
    }

    if (empty($_POST["inputAddress"])) {
        $addressError = "Address is required";
        $addressErrorClass = " is-invalid";
    } else {
        $address = test_input($_POST["inputAddress"]);
        if (!preg_match("/^[a-zA-Z]*$/",$address)) {
            $addressError = "Only letter and white space allowed";
            $addressErrorClass = " is-invalid";
        }
    }

    if (empty($_POST["inputState"])) {
        $stateError = "State is required.";
        $stateErrorClass = " is-invalid";
    } else {
        $state = test_input($_POST["inputState"]);
    }

    if (empty($_POST["inputZipCode"])) {
        $zipcodeError = "Zip Code is required.";
        $zipcodeErrorClass = " is-invalid";
    } else {
        $zipcode = test_input($_POST["inputZipCode"]);
        if (!preg_match("/^[1-9][0-9]*$/",$zipcode)) {
            $zipcodeError = "Please enter a valid Zip Code.";
            $zipcodeErrorClass = " is-invalid";
        }
    }

    if($nameError = "" && $emailError = "" && $contactError = "" && $urlError = "" && $addressError = "" && $stateError = "" && $zipcodeError = "") {
        echo "Successful";
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<?php
require_once("includes/dbconnection.php");
include("includes/session.php");
include("includes/config.php");
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
            <div class="col-12">
                <!-- Card Content -->
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <img src="./img/clinic.png" class="img-fluid" alt="Doctor-Avatar" title="Doctor-Avatar">
                            <div class="custom-file">
                                <input type="file" name="inputAvatar" class="custom-file-input" id="inputAvatar">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <div class="card-inner">
                                <!-- Add Clinic -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputDoctorID">Clinic ID #</label>
                                        <input type="text" name="inputDoctorID" class="form-control" id="inputDoctorID" disabled>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputClinicStatus">Clinic Status</label>
                                        <select name="inputClinicStatus" class="form-control" id="inputClinicStatus" >
                                            <option value="" selected disabled>Choose</option>
                                            <option value="">Approve</option>
                                            <option value="">Not Approve</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputClinicName">Clinic Name</label>
                                        <input type="text" name="inputClinicName" class="form-control<?php echo $nameErrorClass;?>" id="inputClinicName" placeholder="" >
                                        <?php if ($nameError != "") {
                                            echo '<div class="invalid-feedback">'.$nameError.'</div>';
                                        } ?>
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
                                        <input type="text" name="inputContact" class="form-control<?php echo $contactErrorClass;?>" id="inputContact" placeholder="">
                                        <?php if ($contactError != "") {
                                            echo '<div class="invalid-feedback">'.$contactError.'</div>';
                                        } ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputFax">Fax Number</label>
                                        <input type="text" name="inputFax" class="form-control" id="inputFax" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmailAddress">Email Address</label>
                                        <input type="text" name="inputEmailAddress" class="form-control<?php echo $emailErrorClass;?>" id="inputEmailAddress" placeholder="example@address.com" >
                                        <?php if ($emailError != "") {
                                            echo '<div class="invalid-feedback">'.$emailError.'</div>';
                                        } ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputURL">URL</label>
                                        <input type="text" name="inputURL" class="form-control<?php echo $urlErrorClass;?>" id="inputURL" placeholder="www.example.com" >
                                        <?php if ($urlError != "") {
                                            echo '<div class="invalid-feedback">'.$urlError.'</div>';
                                        } ?>
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
                                    <input type="text" name="inputAddress" class="form-control<?php echo $addressErrorClass;?>" id="inputAddress" placeholder="1234 Main St" >
                                    <?php if ($addressError != "") {
                                        echo '<div class="invalid-feedback">'.$addressError.'</div>';
                                    } ?>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Address 2</label>
                                    <input type="text" name="inputAddress2" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" >
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCity">City</label>
                                        <input type="text" name="inputCity" class="form-control" id="inputCity" >
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState">State</label>
                                        <select name="inputState[]" id="inputState" class="form-control<?php echo $stateErrorClass;?>" >
                                            <option value="" selected disabled>Choose...</option>
                                            <option value="">1</option>
                                            <option value="">2</option>
                                            <option value="">3</option>
                                        </select>
                                        <?php if ($stateError != "") {
                                            echo '<div class="invalid-feedback">'.$stateError.'</div>';
                                        } ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZipCode">Zip Code</label>
                                        <input type="text" name="inputZipCode" class="form-control<?php echo $zipcodeErrorClass;?>" id="inputZipCode" >
                                        <?php if ($zipcodeError != "") {
                                            echo '<div class="invalid-feedback">'.$zipcodeError.'</div>';
                                        } ?>
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
    <?php include 'includes/footer.php';?>
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
    $status = mysqli_real_escape_string($conn, $_POST["inputClinicStatus"]);
    $avatar = mysqli_real_escape_string($conn,$_POST["inputAvatar"]);
    $clinic_name = mysqli_real_escape_string($conn,$_POST["inputClinicName"]);
    $contact_number = mysqli_real_escape_string($conn, $_POST["inputContact"]);
    $fax_number = mysqli_real_escape_string($conn,$_POST["inputFax"]);
    $email_address = mysqli_real_escape_string($conn,$_POST["inputEmailAddress"]);
    $url = mysqli_real_escape_string($conn,$_POST["inputURL"]);

    $address = mysqli_real_escape_string($conn,$_POST["inputAddress"]).' '.mysqli_real_escape_string($conn,$_POST["inputAddress2"]);
    $city = mysqli_real_escape_string($conn,$_POST["inputCity"]);
    $state = mysqli_real_escape_string($conn,$_POST["inputState"]);
    $zipcode = mysqli_real_escape_string($conn,$_POST["inputZipCode"]);
?>