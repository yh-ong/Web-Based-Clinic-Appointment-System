<?php
/* function attempt_fail()
{
	global $conn;
	$ip_add = $_SERVER["REMOTE_ADDR"];
	$stmt = $conn->prepare("INSERT INTO ip (address, timestamp) VALUES (?, ?)");
	$stmt->bind_param("ss", $ip_add, CURRENT_TIMESTAMP);
	$stmt->execute();

	$stmt1 = $conn->prepare("SELECT COUNT(*) FROM ip WHERE address LIKE ? AND timestamp > (NOW() - INTERVAL 10 MINUTE)");
	$stmt1->bind_param("s", $ip_add);
	$stmt1->execute();
	$result = $stmt1->get_result();
	$count = $result->fetch_assoc(MYSQLI_NUM);

	if ($count[0] > 3) {
		echo "Your are allowed 3 attempts in 10 minutes";
	}
} */

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

function encrypt_url($data)
{
	return urlencode(base64_encode($data));
}

function decrypt_url($data)
{
	return base64_decode(urldecode($data));
}

function randomToken()
{
	return mt_rand(100000, 999999);
}

function generateCode($limit){
	$code = '';
	for($i = 0; $i < $limit; $i++) { $code .= mt_rand(0, 9); }
	return $code;
}

$ciphering = "AES-256-CBC";
$iv_length = openssl_cipher_iv_length($ciphering); 
$options = 0; 

function encrypt($text, $token) {
	global $ciphering, $iv_length, $options;

	$enfirst = substr($token, 0, 3);
	$enlast = substr($token, -3);
	$encryption_key = $enfirst.$enlast;

	$iv = substr($token, 0, 19);
	$encryption_iv = substr($iv,3);

	return openssl_encrypt($text, $ciphering, $encryption_key, $options, $encryption_iv);
}

function decrypt($entext, $token) {
	global $ciphering, $iv_length, $options;

	$enfirst = substr($token, 0, 3);
	$enlast = substr($token, -3);
	$decryption_key = $enfirst.$enlast;

	$iv = substr($token, 0, 19);
	$decryption_iv = substr($iv,3);
	
	return openssl_decrypt ($entext, $ciphering, $decryption_key, $options, $decryption_iv);
}