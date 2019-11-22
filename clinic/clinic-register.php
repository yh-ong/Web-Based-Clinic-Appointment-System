<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
include('../helper/select_helper.php');

if ($_SESSION["loggedin"] != 1)
    header("Location: register.php");

$sess_email = $_SESSION["sess_email"];
$result1 = mysqli_query($conn, "SELECT * FROM clinic_manager WHERE clinicadmin_email = '" . $sess_email . "' ");
$row1 = mysqli_fetch_assoc($result1);
$clinic_id = $row1["clinic_id"];

$result = mysqli_query($conn, "SELECT * FROM clinics WHERE clinic_id = '" . $clinic_id . "' ");
$row = mysqli_fetch_assoc($result);
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS_PATH; ?>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="container">
        <div class="title text-center mt-5">
            <h3><a href="login.php"><?php echo $BRAND_NAME; ?></a></h3>
        </div>
        <form name="registerForm" id="registerForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <ul class="timeline mb-5" id="timeline">
                <li class="li">
                    <div class="timestamp">
                        <span class="frame">Step 1</span>
                    </div>
                    <div class="status">
                        <h4>Detail</h4>
                    </div>
                </li>
                <li class="li">
                    <div class="timestamp">
                        <span class="frame">Step 2</span>
                    </div>
                    <div class="status">
                        <h4>Contact</h4>
                    </div>
                </li>
                <li class="li">
                    <div class="timestamp">
                        <span class="frame">Step 3</span>
                    </div>
                    <div class="status">
                        <h4>Location</h4>
                    </div>
                </li>
                <li class="li">
                    <div class="timestamp">
                        <span class="frame">Step 4</span>
                    </div>
                    <div class="status">
                        <h4>Picture</h4>
                    </div>
                </li>
            </ul>

            <div class="register-wrap">
                <!-- Details -->
                <div class="tab">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputClinicName">Clinic Name</label>
                            <input type="text" name="inputClinicName" class="form-control" id="inputClinicName" placeholder="Enter Name" value="<?php echo $row["clinic_name"]; ?>">
                        </div>
                    </div>
                    <label for="inputBusinessHour">Business Hour</label>
                    <div class="mb-3">
                        <small class="text-muted">When you're closed on a certain day, just leave the hours blank.</small>
                        <small class="text-muted">Remember: 12PM is midday, 12AM is midnight</small>
                    </div>
                    <div class="form-group row">
                        <label for="inputBusinessHourWeek" class="col-sm-2 col-form-label text-right">Monday - Friday</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputOpensHourWeek">
                        </div><span>--</span>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputCloseHourWeek">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputBusinessHourSat" class="col-sm-2 col-form-label text-right">Saturday</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputOpensHourSat">
                        </div><span>--</span>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputCloseHourSat">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputBusinessHourSun" class="col-sm-2 col-form-label text-right">Sunday</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputOpensHourSun">
                        </div><span>--</span>
                        <div class="col-sm-4">
                            <input type="text" class="form-control timepicker" name="inputCloseHourSun">
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="tab">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputContact">Contact Number</label>
                            <input type="text" name="inputContact" class="form-control" id="inputContact" placeholder="Enter Phone Number" value="<?php echo $row["clinic_contact"]; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmailAddress">Email Address*</label>
                            <input type="text" name="inputEmailAddress" class="form-control" id="inputEmailAddress" placeholder="Enter Email Address" value="<?php echo $row["clinic_email"]; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputURL">URL Link</label>
                            <input type="text" name="inputURL" class="form-control" id="inputURL" placeholder="Enter URL" value="<?php echo $row["clinic_url"]; ?>">
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="tab">
                    <div class="form-group">
                        <label for="inputAddress">Address</label>
                        <input type="text" name="inputAddress" class="form-control" id="inputAddress" placeholder="1234 Main St" value="<?php echo $row["clinic_address"]; ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">City</label>
                            <input type="text" name="inputCity" class="form-control" id="inputCity" value="<?php echo $row["clinic_city"]; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState">State</label>
                            <select name="inputState" id="inputState" class="form-control">
                                <option value="" selected disabled>Choose</option>
                                <?php foreach ($select_state as $state_value) {
                                    echo '<option value="' . $state_value . '">' . $state_value . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputZipCode">Zip Code</label>
                            <input type="text" name="inputZipCode" class="form-control" id="inputZipCode" value="<?php echo $row["clinic_zipcode"]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8143925.994012329!2d104.27361250804562!3d4.312032342074196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3034d3975f6730af%3A0x745969328211cd8!2sMalaysia!5e0!3m2!1sen!2smy!4v1564231608574!5m2!1sen!2smy" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>

                <!-- <div class="tab">
                    <p><input placeholder="Username..." oninput="this.className = ''"></p>
                    <p><input placeholder="Password..." oninput="this.className = ''"></p>
                </div> -->
                <small>* Compulsory</small>
            </div>

            <div class="mt-3">
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-primary btn-block" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary btn-block" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php include JS_PATH; ?>
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form ...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            // ... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            // ... and run a function that displays the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form... :
            if (currentTab >= x.length) {
                //...the form gets submitted:
                document.getElementById("registerForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false:
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("li")[currentTab].className += " complete";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("li");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class to the current step:
            x[n].className += " active";
        }
    </script>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = "0";
    $clinic_name = mysqli_real_escape_string($conn, $_POST["inputClinicName"]);
    $contact = mysqli_real_escape_string($conn, $_POST["inputContact"]);
    $fax = mysqli_real_escape_string($conn, $_POST["inputFax"]);
    $email = mysqli_real_escape_string($conn, $_POST["inputEmailAddress"]);
    $url = mysqli_real_escape_string($conn, $_POST["inputURL"]);
    $address = mysqli_real_escape_string($conn, $_POST["inputAddress"]);
    $city = mysqli_real_escape_string($conn, $_POST["inputCity"]);
    if (!empty($_POST['inputState'])) {
        $state = $_POST['inputState'];
    } else {
        $state = "";
    }
    $zipcode = mysqli_real_escape_string($conn, $_POST["inputZipCode"]);

    $result = mysqli_query($conn, "SELECT * FROM clinics WHERE clinic_email = '.$email.'");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (mysqli_num_rows($result) != 0) {
        echo '<script>alert("Email Already Existed");</script>';
        exit();
    }

    $query = "UPDATE clinics SET clinic_name = '" . $clinic_name . "', clinic_email ='" . $email . "', clinic_url ='" . $url . "', clinic_contact ='" . $contact . "', clinic_address ='" . $address . "', clinic_city = '" . $city . "', clinic_state = '" . $state . "', clinic_zipcode = '" . $zipcode . "', clinic_status= '" . $status . "' WHERE clinic_id = '" . $clinic_id . "' ";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    ob_end_flush();
    mysqli_close($conn);
}
?>