<?php
require(dirname(__DIR__, 3).'/config/config.php');
require(dirname(__DIR__, 3).'/config/database.php');

$email = "";
$password = "";
$error = array();

if (isset($_POST['login_btn'])) {
    isLoggedIn();
}

if (isset($_POST['register_btn'])) {
    register();
}

function register()
{
    global $conn, $error, $email, $password;

    $username    =  e($_POST['username']);
    $email       =  e($_POST['email']);
    $password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database

        if (isset($_POST['user_type'])) {
            $user_type = e($_POST['user_type']);
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
            mysqli_query($conn, $query);
            $_SESSION['success']  = "New user successfully created!!";
            header('location: home.php');
        } else {
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
            mysqli_query($conn, $query);

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($conn);

            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            header('location: index.php');
        }
    }
}

function getUserById($id)
{
    global $conn;
    $query = "SELECT * FROM users WHERE id=" . $id;
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

// escape string
function e($val)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($val));
}

/* function display_error()
{
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
} */

function isLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}
