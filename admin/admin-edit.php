<?php
require_once('../config/autoload.php');
require_once('./includes/path.inc.php');
require_once('./includes/session.inc.php');


$enid = $_REQUEST['aid'];
$id = base64_decode(urldecode($enid));

$errors = array();

if (isset($_POST["savebtn"])) {
    $id         = $admin_row["admin_id"];
    $name       = escape_input($_POST['inputName']);
    $email      = escape_input($_POST['inputEmailAddress']);

    if (empty($name)) {
        array_push($errors, "Name is required");
    }

    if (empty($email)) {
        array_push($errors, "Email Address is required");
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Invalid email format");
        }
    }
}

// Reset Password
if (isset($_POST["resetbtn"])) {
    $id      = $admin_row["admin_id"];
    $oldpass = $conn->real_escape_string($_POST['inputOldPassword']);
    $newpass = $conn->real_escape_string($_POST['inputNewPassword']);
    $conpass = $conn->real_escape_string($_POST['inputConfirmPassword']);

    $passstmt = $conn->prepare("SELECT * FROM admin WHERE admin_id =?");
    $passstmt->bind_param("i", $id);
    $passstmt->execute();
    $result = $passstmt->get_result();
    $row = $result->fetch_assoc();
    $token = $row["admin_token"];
    $password = decrypt($row["admin_pass"], $token);

    if (empty($oldpass)) {
		array_push($errors, "Password is required");
	} elseif (empty($newpass)) {
		array_push($errors, "New Password is required");
	} elseif (empty($conpass)) {
		array_push($errors, "Confirm Password is required");
	} elseif (md5($oldpass) != $password) {
		array_push($errors, "Incorrect Password");
	} elseif (!empty($newpass)) {
        password_validation($newpass);
    } elseif ($newpass != $conpass) {
        array_push($errors, "Password not Equal");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include CSS_PATH; ?>
</head>

<body>
    <?php
        if (isset($_POST["resetbtn"])) {
            if (count($errors) == 0) {
                $newtoken = generateCode(22);
                $en_pass = encrypt(md5($newpass), $newtoken);
                $stmt2 = $conn->prepare("UPDATE admin SET admin_pass = ?, admin_token = ? WHERE admin_id = ?");
                $stmt2->bind_param("ssi", $en_pass, $newtoken, $id);
                if ($stmt2->execute()) {
                    echo '<script>
                        Swal.fire({ title: "Great!", text: "Password Reset Successfully!", type: "success" }).then((result) => {
                            if (result.value) { window.location.href = "admin.php"; }
                        })
                        </script>';
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($conn);
                }
            }
        }
    ?>
    <?php include NAVIGATION; ?>
    <div class="page-content" id="content">
        <?php include HEADER; ?>
        <!-- Page content -->
        <div class="row">
            <div class="col-12">
                <form name="regform" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" autocomplete="off">
                    <?php echo display_error(); ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputAdminID">Admin ID #</label>
                                    <input type="text" name="inputAdminID" class="form-control" id="inputAdminID" value="<?php echo $admin_row["admin_id"]; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputFirstName">Name</label>
                                    <input type="text" name="inputName" class="form-control" id="inputName" placeholder="Enter Name" value="<?php echo $admin_row["admin_name"]; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmailAddress">Email Address</label>
                                    <input type="text" name="inputEmailAddress" class="form-control" id="inputEmailAddress" placeholder="Enter Email Address" value="<?php echo $admin_row["admin_email"]; ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="savebtn">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <form name="resetform" method="POST" action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" autocomplete="off">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputOldPassword">Old Password</label>
                                <input type="password" name="inputOldPassword" class="form-control" id="inputOldPassword" placeholder="Enter Old Password">
                            </div>
                            <div class="form-group">
                                <label for="inputNewPassword">New Password</label>
                                <input type="password" name="inputNewPassword" class="form-control" id="inputNewPassword" placeholder="Enter New Password">
                                <small class="form-text text-muted" id="passwordHelp">Use 8 or more characters with a mix of letters, numbers & symbols</small>
                            </div>
                            <div class="form-group">
                                <label for="inputConfirmPassword">Confirm New Password</label>
                                <input type="password" name="inputConfirmPassword" class="form-control" id="inputConfirmPassword" placeholder="Enter Confirm New Password">
                            </div>
                        </div>
                    </div>
                    <div class="md-3 mt-3">
                        <button type="submit" class="btn btn-primary btn-block" name="resetbtn">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
    <?php include JS_PATH; ?>
</body>

</html>
<?php
// Edit Profile
if (isset($_POST["savebtn"])) {
    if (count($errors) == 0) {
        $stmt = $conn->prepare("UPDATE admin SET admin_name = ?, admin_email = ? WHERE admin_id = ? ");
        $stmt->bind_param("ssi", $name, $email, $id);

        if ($stmt->execute()) {
            $_SESSION['sess_adminemail'] = $email;
            echo '<script>
            Swal.fire({ title: "Great!", text: "Update Successfully!", type: "success" }).then((result) => {
                if (result.value) { window.location.href = "admin.php"; }
            });
            </script>';
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
        $stmt->close();
    }
}
?>