<?php
include_once(__DIR__.'/vendor/autoload.php');

use OTPHP\TOTP;

function createOTP($secret =null){
	return TOTP::create();
}

function otpVerify($secret, $input){
	$otp = TOTP::create($input); // create TOTP object from the secret.
	return $otp->verify($secret); // Returns true if the input is verified, otherwise false.
}