<?php
require_once '../inc/otp.php';

// Note: You must set label before generating the QR code
// $otp->setLabel('Label of your web');
// $grCodeUri = $otp->getQrCodeUri(
//     'https://api.qrserver.com/v1/create-qr-code/?data=[DATA]&size=300x300&ecc=M',
//     '[DATA]'
// );
// echo "<img src='{$grCodeUri}'>";
echo "<br>";
echo createOTP();
