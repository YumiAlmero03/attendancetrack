<?php

//load the ar library
include 'phpqrcode/qrlib.php';


//data to be stored in qr
$text = "PRODUCT ID 23456";
 
function upload_qr($text, $filename)
{
	$fileName = $filename.'.png'; 
	$tempDir = "/";                   
	$filePath = $tempDir . "/" . $fileName;

	require 'vendor/autoload.php';

	$s3 = new Aws\S3\S3Client([
		'region'  => 'ap-southeast-1',
		'version' => 'latest',
		'credentials' => [
			'key'    => "AKIAVZ4H6LJO4JMRJISB",
			'secret' => "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",
		]
	]);		

	$result = $s3->putObject([
		'Bucket' => 'onsitelogbook-files',
		'Key'    => 'files/qr-'.$fileName,
		'SourceFile' => $filePath			
		]);
	QRcode::png($text, $result['ObjectURL']); 
	return $result['ObjectURL'];

}


?>