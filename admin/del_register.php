<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Clinic Appointment System</title>
    <?php include 'includes/styles.php';?>
    <link rel="stylesheet" href="./css/login.css">
    <script src="./js/sweetalert2.all.min.js"></script>
</head>
<body>
    <?php
    require_once("includes/dbconnection.php");

    $name = $email = $password = $confirm_password = "";
    $name_err = $email_err = $password_err = $confirm_password_err = "";

    if(isset($_POST['submit_register']))
    {
        // Validate username
        if (empty(trim($_POST["name"]))) {
            $name_err = "Please enter a name.";
        } else {
            // Prepare a select statement
            $sql = "SELECT id FROM users WHERE username = ?";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = trim($_POST["username"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "This username is already taken.";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        // Validation Email
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please Enter Your Email.";
        } else if (!preg_match("/^[a-zA-Z ]*$/",(trim($_POST['email'])))) {
            $email_err = "Please Provide a Valid Email";
        } else {
            $email = trim($_POST['email']);
        }

        // Validation Password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please Enter Your Password.";
        } else if (strlen(trim($_POST['password'])) < 6) {
            $password = trim($_POST["password"]);
        } else {
            $password = trim($_POST['password']);
        }

        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Password did not match.";
            }
        }

        // if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //     $name = test_input($_POST["name"]);
        //     $email = test_input($_POST["email"]);
        //     $website = test_input($_POST["website"]);
        //     $comment = test_input($_POST["comment"]);
        //     $gender = test_input($_POST["gender"]);
        //   }
        
        //   function test_input($data) {
        //     $data = trim($data);
        //     $data = stripslashes($data);
        //     $data = htmlspecialchars($data);
        //     return $data;
        //   }

        if(empty($name_err) && empty($password_err) && empty($confirm_password_err))
        {
            $yourName = $conn->real_escape_string($_POST['name']);
            $yourEmail = $conn->real_escape_string($_POST['email']);
            $yourPassword = $conn->real_escape_string($_POST['password']);
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $registered_date = date('Y-m-d H:i:s');

            $sql="INSERT INTO admin (admin_name, admin_email, admin_pass, admin_registered) VALUES ('".$yourName."','".$yourEmail."','".$yourPassword."','".$registered_date."')";

            if (!$result = $conn->query($sql))
            {
                die('There was an error running the query [' . $conn->error . ']');
            } 
            else
            {
                ?>
                <script>
                    Swal.fire({
                        title: 'Good Job!',
                        text: 'Admin Successful Added!',
                        type: 'success',
                        confirmButtonText: 'Cool'
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            window.location.href = "login.php";
                        }
                    });
                </script>
                <?php
            }
            mysqli_close($conn);
        }
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Left -->
            <div class="p-0 col-lg-4">
                <div class="bg-register bg-image"></div>
            </div>
            <!-- End Left Wrap -->
            <!-- Right -->
            <div class="login-wrap bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                <div class="login-box col-11 mx-auto">
                    <h4 class="mb-4 login-title">Clinic Appointment System</h4>
                    <h6 class="mb-3 login-desc">
                        <span class="d-block">Welcome,</span>
                        <span>It only takes a few seconds to create your account</span>
                    </h6>
                    <div class="divider row"></div>
                    
                    <form name="register_form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="exampleEmail" class="">Email</label>
                                    <input name="email" id="email" placeholder="Email here..." type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="examplePassword" class="">Name</label>
                                    <input name="name" id="name" placeholder="Name here..." type="text" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                                    <span class="invalid-feedback"><?php echo $name_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="exampleEmail" class="">Password</label>
                                    <input name="password" id="password" placeholder="Password here..." type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="examplePassword" class="">Password</label>
                                    <input name="confirm_password" id="conf_password" placeholder="Confirm Password here..." type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="divider row"></div>
                        <div class="d-flex align-items-center">
                            <p class="mb-3">Already have an account? <a href="login.php" class="text-primary">Sign In</a></p>
                            <div class="ml-auto">
                                <button type="submit" name="submit_register" class="btn btn-primary">Create Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Right Wrap -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>