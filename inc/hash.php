<?php 

$key = 'sdiheouifh';
function encryp_word($text)
{

    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($text, $cipher, $GLOBALS['key'], $options=OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $GLOBALS['key'], $as_binary=true);
    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
    return $ciphertext;
}

function decrypt_word($text)
{
    
    $c = base64_decode($text);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $GLOBALS['key'], $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $GLOBALS['key'], $as_binary=true);
    if (hash_equals($hmac, $calcmac))// timing attack safe comparison
    {
        return $original_plaintext;
    }
}

function check_pass($text, $hash)
{
    if ($text === decrypt_word($hash)) {
        return 'true';
    }
    return false;
}
function createRandomPassword() { 

    // $chars = "0123456789"; 
    // srand((double)microtime()*1000000); 
    // $i = 0; 
    // $pass = '' ; 

    // while ($i <=5) { 
    //     $num = rand() % 33; 
    //     $tmp = substr($chars, $num, 1); 
    //     $pass = $pass . $tmp; 
    //     $i++; 
    // } 

    return rand(100000,999999); 

} 
 ?>