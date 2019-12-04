<?php
require_once("includes/dbconnection.php");

include("includes/session.php");
include("includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $PAGE_TITLE;?></title>
    <?php include 'includes/styles.php';?>
</head>
<body>
    <?php include 'includes/navigate.php'; ?>
    <!-- Page content holder -->
    <div class="page-content" id="content">
        <?php include 'includes/header.php';?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- Card Content -->
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="d-flex">
                        <div class="card shadow-sm rounded col-9">
                            <div class="card-body">
                                <div class="card-inner">
                                    <!-- Add Patient -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputDoctorID">Doctor ID #</label>
                                            <input type="text" name="inputDoctorID" class="form-control" id="inputDoctorID" disabled>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputTitle">Title</label>
                                            <select name="inputTitle" id="inputTitle" class="form-control">
                                                <option value="">Choose</option>
                                                <option value="">Mr</option>
                                                <option value="">Dr</option>
                                                <option value="">PhD</option>
                                                <option value="">MD</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="inputFirstName">First Name</label>
                                            <input type="text" name="inputFirstName" class="form-control" id="inputFirstName" placeholder="Enter Name">
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="inputLastName">Last Name</label>
                                            <input type="text" name="inputLastName" class="form-control" id="inputLastName" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputSpeciality">Speciality</label>
                                            <select name="inputSpeciality" id="inputSpeciality" class="form-control">
                                                <option selected>Choose</option>
                                                <?php
                                                    $table_result = mysqli_query($conn, "SELECT * FROM speciality");
                                                    while ($table_row = mysqli_fetch_assoc($table_result)) {
                                                        echo '<option value="'.$table_row["speciality_name"].'">'.$table_row["speciality_name"].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputDoctorStatus">Doctor Status</label>
                                            <select name="inputDoctorStatus" class="form-control" id="inputDoctorStatus">
                                                <option value="">Choose</option>
                                                <option value="">Approve</option>
                                                <option value="">Not Approve</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End Add Patient -->
                                </div>
                            </div>
                        </div>
                        
                        <div class="card col-3">
                            <div class="card-body">
                                <img src="./img/doctor.jpg" class="img-fluid" alt="Doctor-Avatar" title="Doctor-Avatar">
                                <div class="custom-file">
                                    <input type="file" name="inputAvatar" class="custom-file-input" id="inputAvatar">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <div class="card-inner">
                                <!-- Add Patient -->
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputGender">Gender</label>
                                        <select name="inputGender" id="inputGender" class="form-control">
                                            <option selected>Choose</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputLanaguages">Languages Spoke</label>
                                        <select name="inputLanaguages" id="inputLanaguages" class="form-control">
                                            <option selected>Choose</option>
                                            <option value="">English</option>
                                            <option value="">Malay</option>
                                            <option value="">Chinese</option>
                                            <option value="">Tamil</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputDOB">Date of Birth</label>
                                        <input type="text" name="inputDOB" class="form-control" id="datepicker" placeholder="Enter Date of Birth">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputAge">Age</label>
                                        <input type="text" name="inputAge" class="form-control" id="inputAge" placeholder="Enter Age">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputContact">Contact Number</label>
                                        <input type="text" name="inputContact" class="form-control" id="inputContact" placeholder="Enter Phone Number">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputFax">Fax Number</label>
                                        <input type="text" name="inputFax" class="form-control" id="inputFax" placeholder="Enter Fax Number">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmailAddress">Email Address</label>
                                        <input type="text" name="inputEmailAddress" class="form-control" id="inputEmailAddress" placeholder="Enter Email Address">
                                    </div>
                                </div>
                                <!-- End Add Patient -->
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <div class="card-inner">
                                <!-- Add Patient -->
                                <div class="form-group">
                                    <label for="inputAddress">Address</label>
                                    <input type="text" name="inputAddress" class="form-control" id="inputAddress" placeholder="1234 Main St">
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Address 2</label>
                                    <input type="text" name="inputAddress2" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCity">City</label>
                                        <input type="text" name="inputCity" class="form-control" id="inputCity">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputState">State</label>
                                        <select name="inputState" id="inputState" class="form-control">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputZipCode">Zip</label>
                                        <input type="text" name="inputZipCode" class="form-control" id="inputZipCode">
                                    </div>
                                </div>
                                <!-- End Add Patient -->
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="savebtn">Add Doctor</button>
                    </div>
                </form>
                <!-- End Card Content -->
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include 'includes/script.php';?>
</body>
</html>

<?php
if(isset($_POST["savebtn"])) {
    $status = $_POST["inputDoctorStatus"];
    $avatar = $_POST["inputAvatar"];
    $title = $_POST["inputTitle"];
    $firstname = $_POST["inputFirstName"];
    $lastname = $_POST["inputLastName"];
    $speciality = $_POST["inputSpeciality"];
    $gender = $_POST["inputGender"];

    $full_name = $first + $last;

    $language = $_POST["inputLanaguages"];

    $dob = $_POST["inputDOB"];
    $age = $_POST["inputAge"];
    $contact_number = $_POST["inputContact"];
    $fax_number = $_POST["inputFax"];
    $email_address = $_POST["inputEmailAddress"];

    $address1 = $_POST["inputAddress"];
    $address2 = $_POST["inputAddress2"];
    $city = $_POST["inputCity"];
    $state = $_POST["inputState"];
    $zip = $_POST["inputZipCode"];

    $sql = "INSERT INTO doctor (doctor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    // Create Prepared Statement
    $stmt - mysqli_stmt_init($conn);
    // Prepare the prepared statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'SQL Statement Fail';
    } else {
        // Bind Parameter
        mysqli_stmt_bind_param($stmt, "s", $title);
        mysqli_stmt_execute($stmt);
    }
    
}