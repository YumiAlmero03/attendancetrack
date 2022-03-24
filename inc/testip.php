
<?php
	if(isset($_FILES['image'])){
		$file_name = 'files/'.$_FILES['image']['name'];   
		$temp_file_location = $_FILES['image']['tmp_name']; 

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
			'Key'    => $file_name,
			'SourceFile' => $temp_file_location			
		]);

		var_dump($result['ObjectURL']);
	}
?>

<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">         
	<input type="file" name="image" />
	<input type="submit"/>
</form>
<img src="https://onsitelogbook-files.s3.ap-southeast-1.amazonaws.com/files/149071.png">