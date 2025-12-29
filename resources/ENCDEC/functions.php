<?php
//echo base64_encode(openssl_random_pseudo_bytes(32));
define("ENC_KEY",'y3OpddL0mQl65Fi1hzLT/yM+Ula/ItO4FQw4SwRopq0=');

function safe_b64encode($string='') {
	$data = base64_encode($string);
	$data = str_replace(['+','/','='],['-','_',''],$data);
	return $data;
}

function safe_b64decode($string='') {
	$data = str_replace(['-','_'],['+','/'],$string);
	$mod4 = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	return base64_decode($data);
}

function my_encrypt($data) {
    // Remove the base64 encoding from our key
	$encryption_key = base64_decode(ENC_KEY);
    // Generate an initialization vector
	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
	$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
	return safe_b64encode($encrypted . '::' . $iv);
}

function my_decrypt($data) {
	//echo $data;
	//echo "<br>".safe_b64decode($data);
    // Remove the base64 encoding from our key
	$encryption_key = base64_decode(ENC_KEY);
    // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
	list($encrypted_data, $iv) = explode('::', safe_b64decode($data), 2);
	//echo "<br>".$encrypted_data;
	//echo "<br>".$iv;
	return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

function does_url_exists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}
?>