<?php

// Include the SDK using the composer autoloader
require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
	'region'  => '-- your region --',
	'version' => 'latest',
	'credentials' => [
	    'key'    => "AKIAVZ4H6LJO4JMRJISB",
	    'secret' => "fzRL63G0VLNQ94nlXkYyp6VteRX8JWICh0XmO1SE",
	]
]);

// Send a PutObject request and get the result object.
$key = 'files';

$result = $s3->putObject([
	'Bucket' => 'elasticbeanstalk-ap-southeast-1-399180192349',
	'Key'    => $key,
	'Body'   => 'this is the body!',
	//'SourceFile' => 'c:\samplefile.png' -- use this if you want to upload a file from a local location
]);

// Print the body of the result by indexing into the result object.
var_dump($result);