<?php
function attempt_fail()
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
}

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

// $crypt_key = "oru-9(£20fjasdiofewfqwfh;klncsahei223gfpaoeighew";
/* $crypt_key = "aNdRgUkXp2s5v8y/B?E(H+MbQeShVmYq";
function encrypt_url($encrypt)
{
	global $crypt_key;

	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
	$passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $crypt_key, $encrypt, MCRYPT_MODE_ECB, $iv);
	$encode = base64_encode($passcrypt);

	return $encode;
}

//Decrypt Function
function decrypt_url($decrypt)
{
	global $crypt_key;

	$decoded = base64_decode($decrypt);
	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
	$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $crypt_key, $decoded, MCRYPT_MODE_ECB, $iv);

	return str_replace("\\0", '', $decrypted);
} */