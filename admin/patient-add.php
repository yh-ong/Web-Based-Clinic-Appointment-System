<?php
require_once("includes/dbconnection.php");

include("includes/session.php");
include("includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/styles.php'; ?>
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
    <?php include 'includes/navigate.php'; ?>
    <div class="page-content" id="content">
        <?php include 'includes/header.php'; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <!-- <div class="d-flex mb-3">
                    <h5 class="card-title mr-auto">Add Patient</h5>
                </div> -->
                <!-- Card Content -->
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="d-flex">
                        <div class="card col-md-9">
                            <div class="card-body">
                                <div class="card-inner">
                                    <!-- Add Patient -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputPatientID">Patient ID #</label>
                                            <input type="text" name="inputPatientID" class="form-control" id="inputPatientID" disabled>
                                        </div>
                                    </div>
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
                                            <option value="afghan">Afghan</option>
                                            <option value="albanian">Albanian</option>
                                            <option value="algerian">Algerian</option>
                                            <option value="american">American</option>
                                            <option value="andorran">Andorran</option>
                                            <option value="angolan">Angolan</option>
                                            <option value="antiguans">Antiguans</option>
                                            <option value="argentinean">Argentinean</option>
                                            <option value="armenian">Armenian</option>
                                            <option value="australian">Australian</option>
                                            <option value="austrian">Austrian</option>
                                            <option value="azerbaijani">Azerbaijani</option>
                                            <option value="bahamian">Bahamian</option>
                                            <option value="bahraini">Bahraini</option>
                                            <option value="bangladeshi">Bangladeshi</option>
                                            <option value="barbadian">Barbadian</option>
                                            <option value="barbudans">Barbudans</option>
                                            <option value="batswana">Batswana</option>
                                            <option value="belarusian">Belarusian</option>
                                            <option value="belgian">Belgian</option>
                                            <option value="belizean">Belizean</option>
                                            <option value="beninese">Beninese</option>
                                            <option value="bhutanese">Bhutanese</option>
                                            <option value="bolivian">Bolivian</option>
                                            <option value="bosnian">Bosnian</option>
                                            <option value="brazilian">Brazilian</option>
                                            <option value="british">British</option>
                                            <option value="bruneian">Bruneian</option>
                                            <option value="bulgarian">Bulgarian</option>
                                            <option value="burkinabe">Burkinabe</option>
                                            <option value="burmese">Burmese</option>
                                            <option value="burundian">Burundian</option>
                                            <option value="cambodian">Cambodian</option>
                                            <option value="cameroonian">Cameroonian</option>
                                            <option value="canadian">Canadian</option>
                                            <option value="cape verdean">Cape Verdean</option>
                                            <option value="central african">Central African</option>
                                            <option value="chadian">Chadian</option>
                                            <option value="chilean">Chilean</option>
                                            <option value="chinese">Chinese</option>
                                            <option value="colombian">Colombian</option>
                                            <option value="comoran">Comoran</option>
                                            <option value="congolese">Congolese</option>
                                            <option value="costa rican">Costa Rican</option>
                                            <option value="croatian">Croatian</option>
                                            <option value="cuban">Cuban</option>
                                            <option value="cypriot">Cypriot</option>
                                            <option value="czech">Czech</option>
                                            <option value="danish">Danish</option>
                                            <option value="djibouti">Djibouti</option>
                                            <option value="dominican">Dominican</option>
                                            <option value="dutch">Dutch</option>
                                            <option value="east timorese">East Timorese</option>
                                            <option value="ecuadorean">Ecuadorean</option>
                                            <option value="egyptian">Egyptian</option>
                                            <option value="emirian">Emirian</option>
                                            <option value="equatorial guinean">Equatorial Guinean</option>
                                            <option value="eritrean">Eritrean</option>
                                            <option value="estonian">Estonian</option>
                                            <option value="ethiopian">Ethiopian</option>
                                            <option value="fijian">Fijian</option>
                                            <option value="filipino">Filipino</option>
                                            <option value="finnish">Finnish</option>
                                            <option value="french">French</option>
                                            <option value="gabonese">Gabonese</option>
                                            <option value="gambian">Gambian</option>
                                            <option value="georgian">Georgian</option>
                                            <option value="german">German</option>
                                            <option value="ghanaian">Ghanaian</option>
                                            <option value="greek">Greek</option>
                                            <option value="grenadian">Grenadian</option>
                                            <option value="guatemalan">Guatemalan</option>
                                            <option value="guinea-bissauan">Guinea-Bissauan</option>
                                            <option value="guinean">Guinean</option>
                                            <option value="guyanese">Guyanese</option>
                                            <option value="haitian">Haitian</option>
                                            <option value="herzegovinian">Herzegovinian</option>
                                            <option value="honduran">Honduran</option>
                                            <option value="hungarian">Hungarian</option>
                                            <option value="icelander">Icelander</option>
                                            <option value="indian">Indian</option>
                                            <option value="indonesian">Indonesian</option>
                                            <option value="iranian">Iranian</option>
                                            <option value="iraqi">Iraqi</option>
                                            <option value="irish">Irish</option>
                                            <option value="israeli">Israeli</option>
                                            <option value="italian">Italian</option>
                                            <option value="ivorian">Ivorian</option>
                                            <option value="jamaican">Jamaican</option>
                                            <option value="japanese">Japanese</option>
                                            <option value="jordanian">Jordanian</option>
                                            <option value="kazakhstani">Kazakhstani</option>
                                            <option value="kenyan">Kenyan</option>
                                            <option value="kittian and nevisian">Kittian and Nevisian</option>
                                            <option value="kuwaiti">Kuwaiti</option>
                                            <option value="kyrgyz">Kyrgyz</option>
                                            <option value="laotian">Laotian</option>
                                            <option value="latvian">Latvian</option>
                                            <option value="lebanese">Lebanese</option>
                                            <option value="liberian">Liberian</option>
                                            <option value="libyan">Libyan</option>
                                            <option value="liechtensteiner">Liechtensteiner</option>
                                            <option value="lithuanian">Lithuanian</option>
                                            <option value="luxembourger">Luxembourger</option>
                                            <option value="macedonian">Macedonian</option>
                                            <option value="malagasy">Malagasy</option>
                                            <option value="malawian">Malawian</option>
                                            <option value="malaysia">Malaysia</option>
                                            <option value="maldivan">Maldivan</option>
                                            <option value="malian">Malian</option>
                                            <option value="maltese">Maltese</option>
                                            <option value="marshallese">Marshallese</option>
                                            <option value="mauritanian">Mauritanian</option>
                                            <option value="mauritian">Mauritian</option>
                                            <option value="mexican">Mexican</option>
                                            <option value="micronesian">Micronesian</option>
                                            <option value="moldovan">Moldovan</option>
                                            <option value="monacan">Monacan</option>
                                            <option value="mongolian">Mongolian</option>
                                            <option value="moroccan">Moroccan</option>
                                            <option value="mosotho">Mosotho</option>
                                            <option value="motswana">Motswana</option>
                                            <option value="mozambican">Mozambican</option>
                                            <option value="namibian">Namibian</option>
                                            <option value="nauruan">Nauruan</option>
                                            <option value="nepalese">Nepalese</option>
                                            <option value="new zealander">New Zealander</option>
                                            <option value="ni-vanuatu">Ni-Vanuatu</option>
                                            <option value="nicaraguan">Nicaraguan</option>
                                            <option value="nigerien">Nigerien</option>
                                            <option value="north korean">North Korean</option>
                                            <option value="northern irish">Northern Irish</option>
                                            <option value="norwegian">Norwegian</option>
                                            <option value="omani">Omani</option>
                                            <option value="pakistani">Pakistani</option>
                                            <option value="palauan">Palauan</option>
                                            <option value="panamanian">Panamanian</option>
                                            <option value="papua new guinean">Papua New Guinean</option>
                                            <option value="paraguayan">Paraguayan</option>
                                            <option value="peruvian">Peruvian</option>
                                            <option value="polish">Polish</option>
                                            <option value="portuguese">Portuguese</option>
                                            <option value="qatari">Qatari</option>
                                            <option value="romanian">Romanian</option>
                                            <option value="russian">Russian</option>
                                            <option value="rwandan">Rwandan</option>
                                            <option value="saint lucian">Saint Lucian</option>
                                            <option value="salvadoran">Salvadoran</option>
                                            <option value="samoan">Samoan</option>
                                            <option value="san marinese">San Marinese</option>
                                            <option value="sao tomean">Sao Tomean</option>
                                            <option value="saudi">Saudi</option>
                                            <option value="scottish">Scottish</option>
                                            <option value="senegalese">Senegalese</option>
                                            <option value="serbian">Serbian</option>
                                            <option value="seychellois">Seychellois</option>
                                            <option value="sierra leonean">Sierra Leonean</option>
                                            <option value="singaporean">Singaporean</option>
                                            <option value="slovakian">Slovakian</option>
                                            <option value="slovenian">Slovenian</option>
                                            <option value="solomon islander">Solomon Islander</option>
                                            <option value="somali">Somali</option>
                                            <option value="south african">South African</option>
                                            <option value="south korean">South Korean</option>
                                            <option value="spanish">Spanish</option>
                                            <option value="sri lankan">Sri Lankan</option>
                                            <option value="sudanese">Sudanese</option>
                                            <option value="surinamer">Surinamer</option>
                                            <option value="swazi">Swazi</option>
                                            <option value="swedish">Swedish</option>
                                            <option value="swiss">Swiss</option>
                                            <option value="syrian">Syrian</option>
                                            <option value="taiwanese">Taiwanese</option>
                                            <option value="tajik">Tajik</option>
                                            <option value="tanzanian">Tanzanian</option>
                                            <option value="thai">Thai</option>
                                            <option value="togolese">Togolese</option>
                                            <option value="tongan">Tongan</option>
                                            <option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option>
                                            <option value="tunisian">Tunisian</option>
                                            <option value="turkish">Turkish</option>
                                            <option value="tuvaluan">Tuvaluan</option>
                                            <option value="ugandan">Ugandan</option>
                                            <option value="ukrainian">Ukrainian</option>
                                            <option value="uruguayan">Uruguayan</option>
                                            <option value="uzbekistani">Uzbekistani</option>
                                            <option value="venezuelan">Venezuelan</option>
                                            <option value="vietnamese">Vietnamese</option>
                                            <option value="welsh">Welsh</option>
                                            <option value="yemenite">Yemenite</option>
                                            <option value="zambian">Zambian</option>
                                            <option value="zimbabwean">Zimbabwean</option>
                                        </select>
                                    </div>
                                    <!-- End Add Patient -->
                                </div>
                            </div>
                        </div>
                        <div class="card col-md-3">
                            <div class="card-body">
                                <div class="imageupload">
                                    <img src="./img/empty-avatar-700x480.png" class="img-fluid thumbnail" alt="Doctor-Avatar" title="Doctor-Avatar">
                                    <div class="file-tab">
                                        <label class="btn btn-sm btn-primary btn-block btn-file">
                                            <span>Browse</span>
                                            <input type="file" name="inputAvatar">
                                        </label>
                                        <!-- <button type="button" class="btn btn-sm btn-primary">Remove</button> -->
                                    </div>
                                </div>

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

    <?php include 'includes/footer.php';?>
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

        $fullname = $conn->real_escape_string($_POST['inputFirstName']).' '.$conn->real_escape_string($_POST['inputLastName']);

        $ic = $conn->real_escape_string($_POST['inputIC']);
        $nationality = $conn->real_escape_string($_POST['inputNationality']);
        $avatars = $conn->real_escape_string($_POST['inputAvatar']);

        //$gender = $_POST['inputGender'];
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

        $address = $conn->real_escape_string($_POST['inputAddress']).' '.$conn->real_escape_string($_POST['inputAddress2']);

        $city = $conn->real_escape_string($_POST['inputCity']);
        $state = $conn->real_escape_string($_POST['inputState']);
        $zipcode = $conn->real_escape_string($_POST['inputZipCode']);

        // Check Email
        $result = mysqli_query($conn,"SELECT * FROM patients WHERE patient_email = '.$email.'");
        if (mysqli_num_rows($result) != 0) {
            echo '<script>alert("Email Already Existed");</script>';
            exit();
        } else if (empty($fullname) && empty($ic) && empty($nationality) && empty($avatar)) {
            echo '<script>alert("Cannot Be Empty");</script>';
            exit();
        } else {
            try {
                $sql = 'INSERT INTO patients 
                        (patient_name, patient_identity, patient_nationality, patient_gender, patient_maritalstatus, patient_dob, patient_age, patient_email, patient_contact, patient_address, patient_city, patient_state, patient_zipcode, date_created)
                        VALUES ("'.$fullname.'", "'.$ic.'", "'.$nationality.'", "'.$gender.'", "'.$marital_status.'", "'.$dob.'", "'.$age.'", "'.$email.'", "'.$contact.'", "'.$address.'", "'.$city.'", "'.$state.'", "'.$zipcode.'","'.$date_created.'")';
                mysqli_query($conn,$sql);
                echo '<script>alert("New record created successfully");s</script>';
                header("Location: patient-add.php");
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }
            mysqli_close($conn);
        }
    }
    ?>
</body>

</html>