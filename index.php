<?php
use Dwivedianuj9118\PhonePePaymentGateway\PhonePe;

require __DIR__ . '/vendor/autoload.php';

$ff = $_GET['q'];

function decryptURL($encryptedUrl) {
    // Manually decode the URL
    $decodedUrl = '';
    $length = strlen($encryptedUrl);
    for ($i = 0; $i < $length; $i++) {
        $decodedUrl .= chr(ord($encryptedUrl[$i]) - 1); // Reverse the character shifting by 1
    }
    return $decodedUrl;
}

$encryptedUrl = $ff; // The encrypted URL
echo "Encrypted URL: " . $encryptedUrl . "<br>";
$decryptedUrl = decryptURL($encryptedUrl);
// echo "Decrypted URL: " . $decryptedUrl . "<br>";
echo "Decrypted URL: " . $decryptedUrl . "<br>";

$parameters = explode('&', $decryptedUrl);

$amount = null;
$email = null;
$service = null;

foreach ($parameters as $param) {
    echo $param . "<br>";
    list($key, $value) = explode('=', $param);
    echo "Key: " . $key . "<br>";

    if ($key === 'amount') {
        $amount = $value * 100;
    } elseif ($key === 'email') {
        $email = $value;
    } elseif ($key === 'service') {
        $service = $value;
    }
}


   $redirectUrl = "http://localhost/upi/success.php?q=".$ff;
    $callbackUrl = "http://localhost/upi/success.php?q=".$ff;
     
    // $redirectUrl = "https://upi.hindustanrides.in/success.php?q=".$ff;
    // $callbackUrl = "https://upi.hindustanrides.in/success.php?q=".$ff;
    
 
$config = new PhonePe('M22T3OZPBF2L3','15552b06-6233-41f9-8030-30904da81b4a',1);
// $config = new PhonePe('PGTESTPAYUAT','099eb0cd-02cf-4e2a-8aca-3e6c6aff0399',1);

$merchantTransactionId = 'MUID' . substr(uniqid(), -6);
$merchantOrderId = 'Order' . mt_rand(1000,99999);

$amount = $amount;
// echo "vfdgdsghsdgsd $amount";
$email = $email;
$mode = "PRODUCTION";
$mobileNumber = 9876543210;
$data = $config->PaymentCall("$merchantTransactionId","$merchantOrderId","$amount","$redirectUrl",
"$callbackUrl","$mobileNumber","$mode","$email");

$paymentUrl = $data['url'];
echo $paymentUrl;
// echo '<meta http-equiv="refresh" content="0;url=' . $paymentUrl . '" />';
?>
