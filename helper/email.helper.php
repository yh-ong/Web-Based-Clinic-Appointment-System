<?php
$mail = array(
	"con_subject" => "Confirmation for Appointment",
	"con_title" => "Thanks for registering",
	"con_content"=> "Hi, (Appointment Name), <br> Appointment confirmed with (Doctor Name) on (Wednesday, December 27, 2019) at (5:30PM).",
	"con_button" => NULL,

	"acc_subject" => "Activate Clinic Me Account",
	"acc_title" => "Activate the Account",
	"acc_content" => "Thanks for signning up. To send your first campaign. Please verify your email address and change password by clicking the button below.",
	"acc_button" => "Click Here to Verify Account & Reset Password",

	"fg_subject" => "Reset your Password",
	"fg_title" => "Reset your Password",
	"fg_content" => "We've recerived a request to reset your password. if you didn't make the request, just ignore this email. Otherwise, you can reset your password using this link:",
	"fg_button" => "Click Here to Reset your password"
);

function sendmail($to, $subject, $title, $content, $button, $link, $token)
{
	$button_area = "";
	if (isset($button) && isset($link)) {
		$button_area =  '
		<tr><td style="padding: 20px 0 20px 0; font-family: Arial, sans-serif;" align="center">
			<a href="'.$link.'" target="_blank" style="padding: 8px 20px;border: 1px solid #ffffff;border-radius: 6px; color: #716df9; background-color: #ffffff; text-decoration: none; font-weight: bold;">
				' . $button . '
			</a>
		</td></tr>';
	}

	$token_area = "";
	if (isset($token) && $token != "") {
		$token_area = '
		<tr><td align="center" style="padding: 10px 0 30px 0; color: #ffffff; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
				<strong> Here is your 6 digit number: '.$token.'</strong>
			</td></tr>';
		// $token_area = "Here is your 6 digit number: ". $token;
	}

	$message = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Clinic Me</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#716df9" style="padding: 40px 0 30px 0; color: #ffffff; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							ClinicMe
						</td>
					</tr>
					<tr>
						<td bgcolor="#716df9" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								
								<tr>
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 24px;">
										<b>'.$title.'</b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #ffffff; font-family: Arial, sans-serif; font-size: 21px; line-height: 20px;">
										'.$content.'
									</td>
								</tr>
								'.$token_area.'

								'.$button_area.'
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#716df9" style="padding: 10px 30px 30px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="padding: 0 0 20px 0; color: #dddddd; font-family: Arial, sans-serif; font-size: 12px;" align="center">
										if you didnt create a ClinicMe account, just delete this email<br/> and everything will go back to the way it was.
									</td>
								</tr>
								<tr>
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;line-height: 2;" width="75%" align="center">
										<strong>Copyright &copy; '.date("Y").' ClinicMe. All right reserved</strong><br/>
										For questions about this list, please contact
										<a href="#" style="color: #ffffff;">clinicme@gmail.com</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
';

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <ushotel97@gmail.com>' . "\r\n";
	$headers .= 'Cc: ushotel97@gmail.com' . "\r\n";
	mail($to, $subject, $message, $headers);
	return true;
}