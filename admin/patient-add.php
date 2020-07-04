<?php
require_once('../config/autoload.php');
include('includes/path.inc.php');
include('includes/session.inc.php');
include(SELECT_HELPER);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS_PATH; ?>
    <style>
        .imageupload .btn-file {
            overflow: hidden;
            position: relative;
        }

        .imageupload .btn-file input[type="file"] {
            cursor: inherit;
            display: block;
            font-size: 100px;
            min-height: 100%;
            min-width: 100%;
            opacity: 0;
            position: absolute;
            right: 0;
            text-align: right;
            top: 0;
        }

        /* .imageupload .file-tab button {
            display: none;
        } */

        .imageupload .thumbnail {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include NAVIGATION; ?>
    <div class="page-content" id="content">
        <?php include HEADER; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- <div class="d-flex mb-3">
                    <h5 class="card-title mr-auto">Add Patient</h5>
                </div> -->
                <!-- Card Content -->
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="d-flex">
                        <div class="card col-md-9">
                            <div class="card-body">
                                <div class="card-inner">
                                    <!-- Add Patient -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputFirstName">First Name</label>
                                            <input type="text" name="inputFirstName" class="form-control" id="inputFirstName" placeholder="Enter First Name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputLastName">Last Name</label>
                                            <input type="text" name="inputLastName" class="form-control" id="inputLastName" placeholder="Enter Last Name">
                                        </div>
                                    </div>
    
                                    <div class="form-group">
                                        <label for="inputIC">Identity Card Number/ Passport No</label>
                                        <input type="text" name="inputIC" class="form-control" id="inputIC" placeholder="Enter Identity Card Number/ Passport No">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNationality">Nationality</label>
                                        <select name="inputNationality" id="inputNationality" class="form-control selectpicker" data-live-search="true">
                                            <option value="">Choose</option>
                                            <?php
                                                foreach ($select_nationality as $nationality_value) {
                                                    echo '<option value="'.$nationality_value.'">'.$nationality_value.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- End Add Patient -->
                                </div>
                            </div>
                        </div>
                        <div class="card col-md-3">
                            <div class="card-body">
                                <div class="imageupload">
                                    <img src="../assets/img/empty/empty-avatar.jpg" id="output" class="img-fluid thumbnail" alt="Patient-Avatar" title="Patient-Avatar">
                                    <div class="file-tab">
                                        <label class="btn btn-sm btn-primary btn-block btn-file">
                                            <span>Browse</span>
                                            <input type="file" name="inputAvatar" id="inputAvatar" accept="image/*" onchange="openFile(event)">
                                        </label>
                                    </div>
                                </div>
                                <script>
                                    var openFile = function(file) {
                                        var input = file.target;

                                        var reader = new FileReader();
                                        reader.onload = function() {
                                            var dataURL = reader.result;
                                            var output = document.getElementById('output');
                                            output.src = dataURL;
                                        };
                                        reader.readAsDataURL(input.files[0]);
                                    };
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputGender">Gender</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="inputGenderMale" name="inputGender" class="custom-control-input" value="male">
                                                <label class="custom-control-label" for="inputGenderMale">Male</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="inputGenderFemale" name="inputGender" class="custom-control-input" value="female">
                                                <label class="custom-control-label" for="inputGenderFemale">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputMaritalStatus">Marital Status</label>
                                    <select name="inputMaritalStatus" id="inputMaritalStatus" class="form-control">
                                        <option value="">Choose</option>
                                        <?php foreach ($select_maritalstatus as $maritalstatus_value) {
                                            echo '<option value="'.$maritalstatus_value.'">'.$maritalstatus_value.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputDOB">Date of Birth</label>
                                    <input type="text" name="inputDOB" class="form-control" id="datepicker" placeholder="Enter DOB">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputAge">Age</label>
                                    <input type="text" name="inputAge" class="form-control" id="inputAge" placeholder="Enter Age">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputContactNumber">Contact Number</label>
                                    <input type="text" name="inputContactNumber" class="form-control" id="inputContactNumber" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmailAddress">Email Address</label>
                                    <input type="text" name="inputEmailAddress" class="form-control" id="inputEmailAddress" placeholder="Enter Email Address">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="card-inner">
                                <!-- Add Patient -->
                                <div class="form-group">
                                    <label for="inputAddress">Address</label>
                                    <input type="text" name="inputAddress" class="form-control" id="inputAddress" placeholder="1234 Main St">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCity">City</label>
                                        <input type="text" name="inputCity" class="form-control" id="inputCity">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState">State</label>
                                        <select name="inputState" id="inputState" class="form-control selectpicker" data-live-search="true">
                                            <option value="">Choose</option>
                                            <?php foreach ($select_state as $state_value) {
                                                echo '<option value="' . $state_value . '">' . $state_value . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZipCode">Zip Code</label>
                                        <input type="text" name="inputZipCode" class="form-control" id="inputZipCode">
                                    </div>
                                </div>
                                <!-- End Add Patient -->
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="savebtn">Add Patient</button>
                    </div>
                </form>
                <!-- End Card Content -->
            </div>
        </div>
        <!-- End Page Content -->
    </div>

    <?php include JS_PATH;?>
    <script>
        $('#datepicker').on('changeDate', function() {
            var date = $(this).datepicker('getDate'),
                year =  date.getFullYear(),
                current_year = new Date().getFullYear(),
                totalyear = current_year - year;
            $('#inputAge').val(totalyear);
        });

        $('#inputIC').on('keyup', function() {
            var input = $(this).val(),
                lastnum = input % 10;
            if (lastnum % 2 === 0) {
                $("#inputGenderFemale").prop("checked", true);
            } else {
                $("#inputGenderMale").prop("checked", true);
            }
        });
    </script>

    <?php
    if (isset($_POST['savebtn'])) {

        $firstname = $conn->real_escape_string($_POST['inputFirstName']);
        $lastname = $conn->real_escape_string($_POST['inputLastName']);

        $ic = $conn->real_escape_string($_POST['inputIC']);
        $nationality = $conn->real_escape_string($_POST['inputNationality']);
        $avatars = $_FILES['inputAvatar']['name'];

        if(!empty($_POST['inputGender'])) {
            $gender=$_POST['inputGender'];
        } else {
            $gender = "";
        }
        $marital_status = $conn->real_escape_string($_POST['inputMaritalStatus']);
        $dob = $conn->real_escape_string($_POST['inputDOB']);
        $age = $conn->real_escape_string($_POST['inputAge']);

        $email = $conn->real_escape_string($_POST['inputEmailAddress']);
        $contact = $conn->real_escape_string($_POST['inputContactNumber']);

        $address = $conn->real_escape_string($_POST['inputAddress']);

        $city = $conn->real_escape_string($_POST['inputCity']);
        $state = $conn->real_escape_string($_POST['inputState']);
        $zipcode = $conn->real_escape_string($_POST['inputZipCode']);

        // Check Email
        $result = mysqli_query($conn,"SELECT * FROM patients WHERE patient_email = '.$email.'");
        if (mysqli_num_rows($result) != 0) {
            echo '<script>
                Swal.fire({ title: "Oops!", text: "Field Cannot be Empty such as Name, IC, Nationality & Avatar !", type: "error" }).then((result) => {
                    if (result.value) { window.location.href = "patient-add.php"; }
                });
                </script>';
            exit();
        } else if (empty($firstname) && empty($lastname) && empty($ic) && empty($nationality) && empty($avatar)) {
            echo '<script>
                Swal.fire({ title: "Oops!", text: "Field Cannot be Empty such as Name, IC, Nationality & Avatar !", type: "error" }).then((result) => {
                    if (result.value) { window.location.href = "patient-add.php"; }
                });
                </script>';
            exit();
        } else {
            try {
                $sql = 'INSERT INTO patients 
                        (patient_avatar, patient_firstname, patient_lastname, patient_identity, patient_nationality, patient_gender, patient_maritalstatus, patient_dob, patient_age, patient_email, patient_contact, patient_address, patient_city, patient_state, patient_zipcode, date_created)
                        VALUES ("'.$avatar.'", "'.$firstname.'", "'.$lastname.'", "'.$ic.'", "'.$nationality.'", "'.$gender.'", "'.$marital_status.'", "'.$dob.'", "'.$age.'", "'.$email.'", "'.$contact.'", "'.$address.'", "'.$city.'", "'.$state.'", "'.$zipcode.'","'.$date_created.'")';
                
                if (mysqli_query($conn,$sql)) {
                    $last_id = mysqli_insert_id($conn);
                    if (isset($_FILES["inputAvatar"]["name"])) {
                        $allowed =  array('gif', 'png', 'jpg', 'jpeg');
                        $filename = $_FILES['inputAvatar']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if (!in_array($ext, $allowed)) {
                            echo "<script>Swal.fire('Oops...','Only can be image!','error')</script>";
                            exit();
                        } else {
                            if (!empty($_FILES['inputAvatar']['name'])) {
                                $folderpath = "../uploads/patient/" . $last_id . "/";
                                $path = "../uploads/patient/" .  $last_id . "/" . $_FILES['inputAvatar']['name'];
                                $image = $_FILES['inputAvatar']['name'];
            
                                if (!file_exists($folderpath)) {
                                    mkdir($folderpath, 0777, true);
                                    move_uploaded_file($_FILES['inputAvatar']['tmp_name'], $path);
                                } else {
                                    move_uploaded_file($_FILES['inputAvatar']['tmp_name'], $path);
                                }
                            } else {
                                echo "<script>Swal.fire('Oops...','You should select a file to upload!','error')</script>";
                                exit();
                            }
                        }
                    }
                    echo '<script>
                    Swal.fire({ title: "Great!", text: "New Record Added!", type: "success" }).then((result) => {
                        if (result.value) { window.location.href = "patient-list.php"; }
                    });
                    </script>';
                }
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
            mysqli_close($conn);
        }
    }
    ?>
</body>

</html>