<?php
$regrex = array(
	'text' => "/^[a-zA-Z ]*$/",
	'not_empty' => "[a-z0-9A-Z]+",
	'anything' => "^[\d\D]{1,}\$",
	'username' => "^[\w]{3,32}\$",
	'amount' => "^[-]?[0-9]+\$",
	'phone' => "^[0-9]{10,11}\$",
	'contact' => "/^[0-9]{11}$/",
	'number' => "^[-]?[0-9,]+\$",
	'num' => "/^[1-9][0-9]*$/",
	'2digitforce' => "^\d+\,\d\d\$",
	'2digitopt' => "^\d+(\,\d{2})?\$",
	'words' => "^[A-Za-z]+[A-Za-z \\s]*\$",
	'alfanum' => "^[0-9a-zA-Z ,.-_\\s\?\!]+\$",
	'zipcode' => "^[1-9][0-9]{3}[a-zA-Z]{2}\$",
	'price' => "^[0-9.,]*(([.,][-])|([.,][0-9]{2}))?\$",
	'date' => "^[0-9]{4}[-/][0-9]{1,2}[-/][0-9]{1,2}\$",
	'plate' => "^([0-9a-zA-Z]{2}[-]){2}[0-9a-zA-Z]{2}\$"
);

$error_html = array(
	'errName' => '<div class="invalid-feedback">Name is required.</div>',
	'errFirstName' => '<div class="invalid-feedback">First Name is required.</div>',
	'errLastName' => '<div class="invalid-feedback">Last Name is required.</div>',
	'errSpec' => '<div class="invalid-feedback">Speciality is required.</div>',
	'errYears' => '<div class="invalid-feedback">Years is required.</div>',
	'errDesc' => '<div class="invalid-feedback">Description is required.</div>',
	'errDOB' => '<div class="invalid-feedback">Date of Birth is required.</div>',
	'errGender' => '<div class="invalid-feedback">Gender is required.</div>',
	'errSpoke' => '<div class="invalid-feedback">Spoken Languages is required.</div>',
	'errEmail' => '<div class="invalid-feedback">Email Address is required.</div>',
	'errContact' => '<div class="invalid-feedback">Contact Number is required.</div>',
	'errURL' => '<div class="invalid-feedback">URL is required.</div>',
	'errNationality' => '<div class="invalid-feedback">Nationality is required.</div>',
	'errIdentityNumber' => '<div class="invalid-feedback">Identity Number is required.</div>',
	'errMaritalStatus' => '<div class="invalid-feedback">Marital Status is required.</div>',
	'errAddress' => '<div class="invalid-feedback">Address is required.</div>',
	'errCity' => '<div class="invalid-feedback">City is required.</div>',
	'errState' => '<div class="invalid-feedback">State is required.</div>',
	'errZipcode' => '<div class="invalid-feedback">Zipcode is required.</div>',
	'errFee' => '<div class="invalid-feedback">Fees is required.</div>',

	'errField' => '<div class="invalid-feedback">This Field is Required.</div>',
	'invalidEmail' => '<div class="invalid-feedback">Invalid Email Format</div>',
	'invalidURL' => '<div class="invalid-feedback">Invalid URL Format. Please include http:// || https://</div>',
	'invalidInt' => '<div class="invalid-feedback">Only Number Allowed</div>',
	'invalidText' => '<div class="invalid-feedback">Only letters and white space allowed</div>',
	'invalidContact' => '<div class="invalid-feedback">Invalid Phone Number (max: 11 number)</div>',

	'errClass' => 'is-invalid'
);


function multi_empty()
{
	foreach (func_get_args() as $arg)
		if (empty($arg))
			continue;
		else
			return false;
	return true;
}

function escape_input($data)
{
	global $conn;
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	mysqli_real_escape_string($conn, $data);
	return $data;
}

function display_error()
{
	global $errors;
	if (count($errors) > 0) {
		echo '<div class="alert alert-warning" role="alert">';
		foreach ($errors as $error) {
			echo $error . '<br>';
		}
		echo '</div>';
	}
}

function empty_validation($inputdata, $message)
{
	global $errors;
	if (empty($inputdata)) {
		array_push($errors, $message);
	}
}

function text_validation($text)
{
	global $errors;
	if (!preg_match("/^[a-zA-Z ]*$/", $text)) {
		array_push($errors, "Only letters and white space allowed");
	}
}

function number_validation($number)
{
	global $errors;
	if (!filter_var($number, FILTER_VALIDATE_INT)) {
		array_push($errors, "Only Number Allowed");
	}
}

function email_validation($email)
{
	global $errors;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Invalid Email Format");
	}
}

function website_validation($website)
{
	global $errors;
	if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
		array_push($errors, "Invalid URL");
	}
}

function password_validation($password)
{
	global $errors;
	if (strlen($password) < 8) {
		array_push($errors, "Password Must Contain At Least 8 Characters");
	} elseif (!preg_match("/[0-9]+/", $password)) {
		array_push($errors, "Your Password Must Contain At Least 1 Number");
	} elseif (!preg_match("/[A-Z]+/", $password)) {
		array_push($errors, "Your Password Must Contain At Least 1 Capital Letter");
	} elseif (!preg_match("/[a-z]+/", $password)) {
		array_push($errors, "Your Password Must Contain At Least 1 Lowercase Letter");
	} elseif (!preg_match("/\W/", $password)) {
		array_push($errors, "Password Must Contain At Least 1 Special Character");
	}
}
