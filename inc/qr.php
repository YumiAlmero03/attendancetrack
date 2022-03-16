<?php

//load the ar library
include 'phpqrcode/qrlib.php';


//data to be stored in qr
$text = "PRODUCT ID 23456";
 
function upload_qr($text, $filename)
{
	$fileName = $filename.'.png'; 
	$tempDir = "../uploads/qr";                   
	$filePath = $tempDir . "/" . $fileName;

	QRcode::png($text, $filePath); 
	return $filePath;

}


?>