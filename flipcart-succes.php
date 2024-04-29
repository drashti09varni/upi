<!DOCTYPE html>
<html lang="en">
<!-- http://localhost/upi/index.php?q=bnpvou%3E5%3A1%27xfctjuf%3Egmjqnbsut%2Ftipq -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <title>Payment Status</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <?php
    //params q accress
    if (isset($_GET['q'])) {
        $ff = $_GET['q'];
        $decodedString = base64_decode($ff);
        parse_str($decodedString, $params);
    }
    $ff = $_GET['q'];
    function decryptURL($encryptedUrl)
    {
        $decodedUrl = '';
        $length = strlen($encryptedUrl);
        for ($i = 0; $i < $length; $i++) {
            $decodedUrl .= chr(ord($encryptedUrl[$i]) - 1); // Reverse the character shifting by 1
        }
        return $decodedUrl;
    }

    $encryptedUrl = $ff; // The encrypted URL
// echo "Encrypted URL: " . $encryptedUrl . "<br>";
    $decryptedUrl = decryptURL($encryptedUrl);
    // echo "Decrypted URL: " . $decryptedUrl . "<br>";
    
    $parameters = explode('&', $decryptedUrl);

    $amount = null;
    $email = null;
    $service = null;

    foreach ($parameters as $param) {
        list($key, $value) = explode('=', $param);
        if ($key === 'amount') {
            $amount = $value;
        } elseif ($key === 'email') {
            $email = $value;

        } elseif ($key === 'service') {
            $service = str_replace('_', ' ', ucwords($value));
        } elseif ($key === 'payerName') {
            $payerName = $value;

        } elseif ($key === 'payerEmail') {
            $payerEmail = $value;
        }  elseif ($key === 'website') {
            $website = $value;
        }
    }
// echo $website;

    if (isset($_POST['code']) && !empty($_POST['code'])) {
        if ($_POST['code'] == "PAYMENT_SUCCESS") {
            if ($email && $service) {
                $transactionId = $_POST['transactionId'];
                $amount = $amount;
                $email = $email;
                $service = $service;
                $length = strlen($email);
                $first_two = substr($email, 0, 2);
                $asterisks = str_repeat("*", $length - 4);
                $last_two = substr($email, -10);
                $masked_email = $first_two . $asterisks . $last_two;
                $invoice_html = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
                 
                    <h2 style="text-align: center; color: #333;">Invoice</h2>
                    <hr style="border: 0; border-top: 1px solid #ccc; margin-bottom: 20px;">
                    <p style="margin-bottom: 10px;"><strong>Transaction ID:</strong> ' . htmlspecialchars($transactionId) . '</p>
                    <p style="margin-bottom: 10px;"><strong>Amount:</strong> ' . $amount. '</p>
                    <p style="margin-bottom: 10px;"><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
                    <p style="margin-bottom: 10px;"><strong>Service:</strong> ' . htmlspecialchars($service) . '</p>
                    <hr style="border: 0; border-top: 1px solid #ccc; margin-top: 20px; margin-bottom: 20px;">
                    <p style="text-align: center; margin-top: 20px;">Thank you for your purchase. We will be in touch shortly.</p>
                </div>';
                $to = "drashtidayani2001@gmail.com";
                $subject = 'Invoice for your purchase service.';
                $message = $invoice_html;
                $headers = [
                    "MIME-Version: 1.0",
                    "Content-type: text/html; charset=utf-8", // Update content type to HTML
                    "From: varniinfosoft@gmail.com",
                ];

                $headers = implode("\r\n", $headers);
                if (mail($to, $subject, $message, $headers)) {
                    echo "
                    <div class='card' style='background: #5cb85c; color:#fff; padding: 20px 30px; border-radius: 4px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; margin: 20px auto;'>
                        <p style='color:white; font-size:18px;'>I have sent the invoice to <b>$masked_email</b> this email. Please check your inbox.</p>
                        </div><div></div>
                        <div class='card'>
                            <div style='border-radius: 200px; height: 140px; width: 140px; background: #515151; margin: 0 auto;'>
                                <p class='success-checkmark'>✓</p>
                            </div>
                            <p style='margin-top:20px;'>Transaction ID: " . $_POST['transactionId'] . "</p>
                            <p>Amount: " . $amount . "</p>
                            <p>Email : " . $email . "</p>
                            <p>Service : " . $service . "</p>
                            <h1 class='succes' style='margin-top:5px;'>Success</h1>
                            <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
                            </div>
                            <script>
                            var website =  '$website'; 
                            if (website == 'https://flipmarts.shop') {
                                setTimeout(function() {
                                    window.location.href = 'https://flipmarts.shop';
                                }, 5000);
                            } else {
                                setTimeout(function() {
                                    window.location.href = 'https://luckywinner.axispay.cloud/scratch?payment=SUCCESS';
                                }, 5000);
                            }
                    </script>";
                } else {
                    echo "Failed to send invoice!";
                }
            } else {
                echo "
                <div class='card'>
                    <div style='border-radius:200px; height:200px; width:200px; background: #e6e7e3; margin:0 auto;'>
                        <p class='success-checkmark'>✓</p>
                    </div>
                    <p style='margin-top:20px'>Transaction ID: " . $_POST['transactionId'] . "</p>
                    <p>Amount: " . $amount . "</p>
                    <h1 class='succes' style='margin-top:5px;'>Success</h1>
                    <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
                </div>
                <script>
                var website =  '$website'; 
                if (website == 'https://flipmarts.shop') {
                    setTimeout(function() {
                        window.location.href = 'https://flipmarts.shop';
                    }, 5000);
                } else {
                    setTimeout(function() {
                        window.location.href = 'https://luckywinner.axispay.cloud/scratch?payment=SUCCESS';
                    }, 5000);
                }
        </script>";
                
            }
        } 
        elseif ($_POST['code'] == "PAYMENT_ERROR") {
            if($email & $service){
            echo "
                <div class='card'>
                    <div style='border-radius:200px; height:200px; width:200px; background: #e6e7e3; margin:0 auto;'>
                    <p class='error-checkmark '>×</p>
                </div>
                <p style='margin-top:20px'>Transaction ID: " . $_POST['transactionId'] . "</p>
                <p>Amount: " . $amount . "</p>";
                "<p>Email : " . $email . "</p>";
                "<p>Service : " . $service . "</p>
                <h1 class='error'>Error</h1> 
                <p>We received your purchase request;<br/> well be in touch shortly!</p>
          </div>";

            // JavaScript for redirection
            echo "
            <script>
                var website = '$website'; 
                if (website == 'https://flipmarts.shop') {
                    setTimeout(function() {
                        window.location.href = 'https://flipmarts.shop';
                    }, 5000);
                } else {
                    setTimeout(function() {
                        window.location.href = 'https://luckywinner.axispay.cloud/scratch?payment=FAILED';
                    }, 5000);
                }
            </script>";
            }else{
                echo "
                <div class='card'>
                    <div style='border-radius:200px; height:200px; width:200px; background: #e6e7e3; margin:0 auto;'>
                    <p class='error-checkmark '>×</p>
                </div>
                <p style='margin-top:20px'>Transaction ID: " . $_POST['transactionId'] . "</p>
                <p>Amount: " . $amount . "</p>
                <h1 class='error'>Error</h1> 
                <p>We received your purchase request;<br/> well be in touch shortly!</p>
                </div>";

                // JavaScript for redirection
                echo "
                <script>
                    var website = '$website'; 
                    if (website == 'https://flipmarts.shop') {
                        setTimeout(function() {
                            window.location.href = 'https://flipmarts.shop';
                        }, 5000);
                    } else {
                        setTimeout(function() {
                            window.location.href = 'https://luckywinner.axispay.cloud/scratch?payment=FAILED';
                        }, 5000);
                    }
                </script>";
            }
                
        } elseif ($_POST['code'] == "PAYMENT_PENDING") {
            if ($email & $service) {
                echo "
                        <div class='card'>
                            <div style='border-radius: 200px; height: 140px; width: 140px; background: #515151; margin: 0 auto;'>
                                <p class='pending-checkmark'>!</p>
                            </div>
                            <p style='margin-top:20px;'>Transaction ID: " . $_POST['transactionId'] . "</p>
                            <p>Amount: " . $amount . "</p>
                            <p>Email : " . $email . "</p>
                            <p>Service : " . $service . "</p>
                            <h1 class='pending' style='margin-top:5px;'>pending</h1>
                            <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
                        </div> 
                        <script>
                        var website =  '$website';  // Echo the PHP variable inside JavaScript
                        console.log('Value of website:', website); // Print the value of website variable
                        
                        if (website == 'https://flipmarts.shop') {
                            console.log('Redirecting to https://flipmarts.shop');
                            setTimeout(function() {
                                window.location.href = 'https://flipmarts.shop';
                            }, 5000);
                        } else {
                            console.log('Redirecting to https://luckywinner.axispay.cloud/scratch?payment=PENDING');
                            setTimeout(function() {
                                window.location.href = 'https://luckywinner.axispay.cloud/scratch?payment=PENDING';
                            }, 5000);
                        }
                    </script>";
                    
            } else {
                // Email or service parameters are missing, so don't display the details
                echo "
                        <div class='card'>
                            <div style='border-radius: 200px; height: 140px; width: 140px; background: #515151; margin: 0 auto;'>
                                <p class='pending-checkmark'>!</p>
                            </div>
                            <p style='margin-top:20px;'>Transaction ID: " . $_POST['transactionId'] . "</p>
                            <p>Amount: " . $amount . "</p>";
                if ($email && $service) {
                    echo "<p>Email : " . $email . "</p>";
                    echo "<p>Service : " . $service . "</p>";
                }
                echo " <h1 class='pending' style='margin-top:5px;'>pending</h1>
                            <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
                        </div>  
                        <script>
                        var website =  '$website';  // Echo the PHP variable inside JavaScript
                        console.log('Value of website:', website); // Print the value of website variable
                        
                        if (website == 'https://flipmarts.shop') {
                            setTimeout(function() {
                                window.location.href = 'https://flipmarts.shop';
                            }, 5000);
                        } else {
                            setTimeout(function() {
                                window.location.href = 'https://luckywinners.flipmarts.shop/scratch?payment=PENDING';
                            }, 5000);
                        }
                    </script>" ;
                    
            }

        }


    }
    ?>