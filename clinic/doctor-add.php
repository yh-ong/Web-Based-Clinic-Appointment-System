<?php
include('../config/autoload.php');
include('./includes/path.inc.php');
include('./includes/session.inc.php');

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
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <div class="d-flex">
                        <div class="card col-md-9">
                            <div class="card-body">
                                <!-- Add Doctor -->
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputFirstName">First Name</label>
                                        <input type="text" name="inputFirstName" class="form-control" id="inputFirstName" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputLastName">Last Name/Surname</label>
                                        <input type="text" name="inputLastName" class="form-control" id="inputLastName" placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputSpeciality">Speciality</label>
                                        <select name="inputSpeciality" id="inputSpeciality" class="form-control selectpicker" data-live-search="true">
                                            <option value="" selected disabled>Choose</option>
                                            <?php
                                            $table_result = mysqli_query($conn, "SELECT * FROM speciality");
                                            while ($table_row = mysqli_fetch_assoc($table_result)) {
                                                echo '<option value="' . $table_row["speciality_name"] . '">' . $table_row["speciality_name"] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputYrsExp">Year Experience</label>
                                        <input type="number" name="inputYrsExp" class="form-control" id="inputYrsExp" placeholder="Enter Years Experience">
                                    </div>
                                </div>
                                <!-- End Add Doctor -->
                            </div>
                        </div>

                        <div class="card col-md-3">
                            <div class="card-body">
                                <div class="imageupload">
                                    <img src="../assets/img/empty/empty-avatar.jpg" id="output" class="img-fluid thumbnail" alt="Doctor-Avatar" title="Doctor-Avatar">
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
                                <label for="inputLanguages">Languages Spoke</label><small class="text-muted m-2">We'll never share your email with anyone else.</small>
                                <div class="row">
                                    <?php $i = 1;
                                    foreach ($select_lang as $lang_value) {
                                        echo '<div class="col"><div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="inputLanguages[]" id="customCheck' . $i . '" class="custom-control-input" value="' . $lang_value . '">
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
                                    <label for="inputAge">Age</label>
                                    <input type="text" name="inputAge" class="form-control" id="inputAge" placeholder="Enter Age">
                                </div>
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
                                                <input type="radio" id="inputGenderMale" name="inputGender" class="custom-control-input" value="male">
                                                <label class="custom-control-label" for="inputGenderMale">Male</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="inputGenderFemale" name="inputGender" class="custom-control-input" value="female">
                                                <label class="custom-control-label" for="inputGenderFemale">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
function randomPassword()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

if (isset($_POST["savebtn"])) {
    // $avatar = $conn->real_escape_string($_POST['inputAvatar']);
    $fname       = $conn->real_escape_string($_POST['inputFirstName']);
    $lname       = $conn->real_escape_string($_POST['inputLastName']);
    $speciality = $conn->real_escape_string($_POST['inputSpeciality']);
    $years      = $conn->real_escape_string($_POST['inputYrsExp']);
    $desc       = $conn->real_escape_string($_POST['inputDesc']);
    $lang       = $_POST['inputLanguages'];
    $spoke      = implode(",", $lang);
    $dob        = $conn->real_escape_string($_POST['inputDOB']);
    $gender     = $conn->real_escape_string($_POST['inputGender']);
    $email      = $conn->real_escape_string($_POST['inputEmailAddress']);
    $contact    = $conn->real_escape_string($_POST['inputContactNumber']);

    if (isset($_FILES["inputAvatar"]["name"])) {
        $allowed =  array('gif', 'png', 'jpg');
        $filename = $_FILES['inputAvatar']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            echo "<script>Swal.fire(
                'Oops...',
                'Only can be image!',
                'error'
            )</script>";
            exit();
        } else {
            if (!empty($_FILES['inputAvatar']['name'])) {
                $path = "../database/profile/" . $_FILES['inputAvatar']['name'];
                $image = $_FILES['inputAvatar']['name'];
                move_uploaded_file($_FILES['inputAvatar']['tmp_name'], $path);
            } else {
                echo "<script>Swal.fire(
                    'Oops...',
                    'You should select a file to upload!',
                    'error'
                )</script>";
                exit();
            }
        }
    }

    $password = randomPassword();

    $query = "INSERT INTO doctors (doctor_avatar, doctor_firstname, doctor_lastname, doctor_speciality, doctor_experience, doctor_desc, doctor_password, doctor_spoke, doctor_gender, doctor_dob, doctor_email, doctor_contact, date_created, clinic_id) VALUES ('" . $image . "', '" . $fname . "', '" . $lname . "', '" . $speciality . "', '" . $years . "', '" . $desc . "', '" . $password . "', '" . $spoke . "', '" . $gender . "', '" . $dob . "', '" . $email . "', '" . $contact . "','" . $date_created . "', '" . $clinic_row['clinic_id'] . "')";
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
?>