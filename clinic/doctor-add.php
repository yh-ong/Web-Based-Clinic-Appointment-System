<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

include(SELECT_HELPER);
include(EMAIL_HELPER);

$errFName = $errLName = $errSpec = $errYears = $errFee = $errSpoke = $errGender = $errEmail = $errContact = $errImage = "";
$classFName = $classLName = $classSpec = $classYears = $classFee = $classSpoke = $classGender = $classEmail = $errContact = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname       = escape_input($_POST['inputFirstName']);
    $lname       = escape_input($_POST['inputLastName']);
    if (isset($_POST['inputSpeciality'])) {
        $speciality = escape_input($_POST['inputSpeciality']);
    }
    $years      = escape_input($_POST['inputYrsExp']);
    $fees      = escape_input($_POST['inputFee']);
    $desc       = escape_input($_POST['inputDesc']);
    if (isset($_POST['inputLanguages'])) {
        $lang = $_POST['inputLanguages'];
        $spoke = implode(",", $lang);
    }
    $dob        = escape_input($_POST['inputDOB']);
    if (isset($_POST['inputGender'])) {
        $gender     = escape_input($_POST['inputGender']);
    }
    $email      = escape_input($_POST['inputEmailAddress']);
    $contact    = escape_input($_POST['inputContactNumber']);

    if (empty($fname)) {
        $errFName = $error_html['errFirstName'];
        $classFName = $error_html['errClass'];
    } else {
        if (!preg_match($regrex['text'], $fname)) {
            $errFName = $error_html['invalidText'];
            $classFName = $error_html['errClass'];
        }
    }

    if (empty($lname)) {
        $errLName = $error_html['errLastName'];
        $classLName = $error_html['errClass'];
    } else {
        if (!preg_match($regrex['text'], $lname)) {
            $errFName = $error_html['invalidText'];
            $classFName = $error_html['errClass'];
        }
    }

    if (empty($speciality)) {
        $errSpec = $error_html['errSpec'];
        $classSpec = $error_html['errClass'];
    }

    if (empty($years)) {
        $errYears = $error_html['errYears'];
        $classYears = $error_html['errClass'];
    } else {
        if (!filter_var($years, FILTER_VALIDATE_INT)) {
            $errYears = $error_html['invalidInt'];
            $classYears = $error_html['errClass'];
        }
    }
    
    if (empty($fees)) {
        $errFee = $error_html['errFee'];
        $classFee = $error_html['errClass'];
    } else {
        if (!filter_var($fees, FILTER_VALIDATE_INT)) {
            $errFee = $error_html['invalidInt'];
            $classFee = $error_html['errClass'];
        }
    }

    if (empty($lang)) {
        $errSpoke = $error_html['errSpoke'];
        $classSpoke = $error_html['errClass'];
    }
    if (empty($gender)) {
        $errGender = $error_html['errGender'];
        $classGender = $error_html['errClass'];
    }

    if (empty($email)) {
        $errEmail = $error_html['errEmail'];
        $classEmail = $error_html['errClass'];
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errEmail =  $error_html['invalidEmail'];
            $classEmail = $error_html['errClass'];
        }
    }

    if (empty($contact)) {
        $errContact = $error_html['errContact'];
        $classContact = $error_html['errClass'];
    } else {
        if (!preg_match($regrex['contact'], $contact)) {
            $errContact = $error_html['invalidInt'];
            $classContact = $error_html['errClass'];
        }
    }

    if (empty($_FILES['inputAvatar']['name'])) {
        $errImage = "Image is required";
        $classImage = "invalid";
    }
}
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

        .imageupload .invalid {
            border: 1px solid red;
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
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="d-flex">
                        <div class="card col-md-9">
                            <div class="card-body">
                                <!-- Add Doctor -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputFirstName">First Name</label>
                                        <input type="text" name="inputFirstName" class="form-control <?php echo $classFName ?>" id="inputFirstName" placeholder="Enter First Name">
                                        <?php echo $errFName; ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputLastName">Last Name/Surname</label>
                                        <input type="text" name="inputLastName" class="form-control <?php echo $classFName ?>" id="inputLastName" placeholder="Enter Last Name">
                                        <?php echo $errLName; ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputSpeciality">Speciality</label>
                                        <select name="inputSpeciality" id="inputSpeciality" class="form-control selectpicker <?= $classSpec ?>" data-live-search="true">
                                            <option value="" selected disabled>Choose</option>
                                            <?php
                                            $table_result = mysqli_query($conn, "SELECT * FROM speciality");
                                            while ($table_row = mysqli_fetch_assoc($table_result)) {
                                                echo '<option value="' . $table_row["speciality_id"] . '">' . $table_row["speciality_name"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <?= $errSpec ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputYrsExp">Year Experience</label>
                                        <input type="text" name="inputYrsExp" class="form-control <?= $classYears ?>" id="inputYrsExp" placeholder="Enter Years Experience">
                                        <?= $errYears ?>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputFee">Consultant Fees</label>
                                        <input type="text" name="inputFee" class="form-control <?= $classFee ?>" id="inputFee" placeholder="Enter Consultant Fees">
                                        <?= $errFee ?>
                                    </div>
                                </div>
                                <!-- End Add Doctor -->
                            </div>
                        </div>

                        <div class="card col-md-3">
                            <div class="card-body">
                                <div class="imageupload">
                                    <small class="text-danger"><?= $errImage ?></small>
                                    <img src="../assets/img/empty/empty-avatar.jpg" id="output" class="img-fluid thumbnail <?= $classImage ?>" alt="Doctor-Avatar" title="Doctor-Avatar">
                                    <div class="file-tab">
                                        <label class="btn btn-sm btn-primary btn-block btn-file">
                                            <span>Browse</span>
                                            <input type="file" name="inputAvatar" id="inputAvatar" accept="image/*" onchange="openFile(event)">
                                        </label>
                                        <!-- <button type="button" class="btn btn-sm btn-primary">Remove</button> -->
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
                            <div class="form-group">
                                <label for="inputLanguages">Languages Spoke</label><small class="text-muted m-2">Select Multiple Languages You Spoked.</small>
                                <div class="row">
                                    <?php $i = 1;
                                    foreach ($select_lang as $lang_value) {
                                        echo
                                            '<div class="col">
                                            <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="inputLanguages[]" id="customCheck' . $i . '" class="custom-control-input ' . $classSpoke . '" value="' . $lang_value . '">
                                            <label class="custom-control-label" for="customCheck' . $i . '">' . $lang_value . '</label>
                                        </div></div>';
                                        $i++;
                                    } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputDesc">Describe</label>
                                <textarea class="form-control" id="inputDesc" name="inputDesc" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputDOB">Date of Birth</label>
                                    <input type="text" name="inputDOB" class="form-control" id="datepicker" placeholder="Enter DOB">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputGender">Gender</label>
                                    <div class="row">
                                        <div class="col">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="inputGenderMale" name="inputGender" class="custom-control-input <?= $classGender ?>" value="male">
                                                <label class="custom-control-label" for="inputGenderMale">Male</label>
                                                <?= $errGender ?>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="inputGenderFemale" name="inputGender" class="custom-control-input <?= $classGender ?>" value="female">
                                                <label class="custom-control-label" for="inputGenderFemale">Female</label>
                                                <?= $errGender ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputContactNumber">Contact Number</label>
                                    <input type="text" name="inputContactNumber" class="form-control <?= $classContact ?>" id="inputContactNumber" placeholder="Enter Phone Number">
                                    <?= $errContact ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputEmailAddress">Email Address</label>
                                    <input type="text" name="inputEmailAddress" class="form-control <?= $classEmail ?>" id="inputEmailAddress" placeholder="Enter Email Address">
                                    <?= $errEmail ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button type="reset" class="btn btn-outline-secondary btn-block">Clear</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block" name="savebtn">Add Doctor</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
    <script>
        $('#datepicker').on('changeDate', function() {
            var date = $(this).datepicker('getDate'),
                year = date.getFullYear(),
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
</body>

</html>
<?php
if (isset($_POST["savebtn"])) {
    // ! prefer use empty() for each instead of function multi_empty()  *stackoverflow
    if (multi_empty($errFName, $errLName, $errSpec, $errYears, $errFee, $errSpoke, $errGender, $errEmail, $errContact, $errImage)) {

        if (isset($_FILES["inputAvatar"]["name"])) {
            $allowed =  array('gif', 'png', 'jpg', 'jpeg');
            $filename = $_FILES['inputAvatar']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                echo "<script>Swal.fire('Oops...','Only can be image!','error')</script>";
                exit();
            } else {
                if (!empty($_FILES['inputAvatar']['name'])) {
                    $folderpath = "../uploads/" . $clinic_row['clinic_id'] . "/doctor" . "/";
                    $path = "../uploads/" . $clinic_row['clinic_id'] . "/doctor" . "/" . $_FILES['inputAvatar']['name'];
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

        $token = generateCode(6);
        $en_token = md5($token);

        $stmt = $conn->prepare("INSERT INTO doctors (doctor_avatar, doctor_firstname, doctor_lastname, doctor_speciality, doctor_experience, doctor_desc, doctor_spoke, doctor_gender, doctor_dob, doctor_email, doctor_contact, consult_fee, date_created, clinic_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssissssssssi", $image, $fname, $lname, $speciality, $years, $desc, $spoke, $gender, $dob, $email, $contact, $fees, $date_created, $clinic_row['clinic_id']);
        if ($stmt->execute()) {

            $last_id = $conn->insert_id;
            mysqli_query($conn,"INSERT INTO treatment_type (treatment_name, doctor_id) VALUES ('New Patient', $last_id) ");

            $selector = bin2hex(random_bytes(8));
            $validator = random_bytes(32);
            $link = $_SERVER["SERVER_NAME"] . "/doclab/doctor/activate.php?selector=".$selector."&validator=". bin2hex($validator);
            $expries = date("U") + 86400; // one day

            $delstmt = $conn->prepare("DELETE FROM doctor_reset WHERE reset_email = ?");
            $delstmt->bind_param("s", $email);
            $delstmt->execute();

            $hashedToken = password_hash($validator, PASSWORD_DEFAULT);

            $resetstmt = $conn->prepare("INSERT INTO doctor_reset (reset_email, reset_selector, reset_token, reset_expires, activate_token) VALUE (?,?,?,?,?)");
            $resetstmt->bind_param("sssss", $email, $selector, $hashedToken, $expries, $en_token);
            $resetstmt->execute();

            if (sendmail($email, $mail['acc_subject'], $mail['acc_title'], $mail['acc_content'], $mail['acc_button'], $link, $token)) {
                echo '<script>
                Swal.fire({ title: "Great!", text: "New Doctor Added!", type: "success" }).then((result) => {
                    if (result.value) { window.location.href = "doctor-list.php"; }
                });
                </script>';
            } else {
                echo 'Something Wrong';
            }
        } else {
            echo 'Something Wrong';
        }
        $stmt->close();
    }
}
?>