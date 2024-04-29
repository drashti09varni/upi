<!DOCTYPE html>
<html lang="en">

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
    if ((isset($_GET['email'])) && (isset($_GET['service']))) {
        $email = $_GET['email'];
        $service = $_GET['service'];
        $service_data = str_replace('_', ' ', ucwords($service));

    } else {
        $email = "";
        $service = "";

    }
    if (isset($_POST['code']) && !empty($_POST['code'])) {

        // Check if the payment status is success
        if ($_POST['code'] == "PAYMENT_SUCCESS") {
            // Display success message with more attractive UI
            echo "
        <div class='card'>
      <div style='border-radius:200px; height:200px; width:200px; background: #e6e7e3; margin:0 auto;'>
        <p class='success-checkmark'>✓</p>
      </div>
      <p style='margin-top:20px'>Transaction ID: " . $_POST['transactionId'] . "</p>
      <p>Amount: " . rtrim($_POST['amount'], '0') . "</p>";
            if (isset($_GET['email']) && isset($_GET['service'])) {
                $email = $_GET['email'];
                $service_data = $_GET['service'];
                echo "<p>Email : " . $email . "</p>";
                echo "<p>Service : " . $service_data . "</p>";
            }
            echo "<h1 class='succes'>Success</h1> 
        <p>We received your purchase request;<br/> well be in touch shortly!</p>";
            "</div>";
        } elseif ($_POST['code'] == "PAYMENT_ERROR") {
            echo "
        <div class='card'>
     <div style='border-radius:200px; height:200px; width:200px; background: #e6e7e3; margin:0 auto;'>
         <p class='error-checkmark '>×</p>
     </div>
     <p style='margin-top:20px'>Transaction ID: " . $_POST['transactionId'] . "</p>
        <p>Amount: " . rtrim($_POST['amount'], '0') . "</p>";
            if (isset($_GET['email']) && isset($_GET['service'])) {
                $email = $_GET['email'];
                $service_data = $_GET['service'];
                echo "<p>Email : " . $email . "</p>";
                echo "<p>Service : " . $service_data . "</p>";
            }
            echo "<h1 class='error'>Error</h1> 
          <p>We received your purchase request;<br/> well be in touch shortly!</p>";
            "</div>";
        } elseif ($_POST['code'] == "PAYMENT_PENDING") {
            // Build invoice HTM
    
            // Check if email and service parameters are set
            if (isset($_GET['email']) && isset($_GET['service'])) {
                $transactionId = $_POST['transactionId'];
                $amount = $_POST['amount'];
                $email = $_GET['email'];
                $service_data = $_GET['service'];

            }


            $invoice_html = '
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;">
    <div style="text-align: center;">
        <h1>Astrologys Report</h1>
    </div>
    <h2 style="text-align: center; color: #333;">Invoice</h2>
    <hr style="border: 0; border-top: 1px solid #ccc; margin-bottom: 20px;">
    <p style="margin-bottom: 10px;"><strong>Transaction ID:</strong> ' . htmlspecialchars($transactionId) . '</p>
    <p style="margin-bottom: 10px;"><strong>Amount:</strong> ' . substr($_POST['amount'], 0, -2) . '</p>
    <p style="margin-bottom: 10px;"><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
    <p style="margin-bottom: 10px;"><strong>Service:</strong> ' . htmlspecialchars($service_data) . '</p>
    <hr style="border: 0; border-top: 1px solid #ccc; margin-top: 20px; margin-bottom: 20px;">
    <p style="text-align: center; margin-top: 20px;">Thank you for your purchase. We will be in touch shortly.</p>
</div>';

            $to = "drashtidayani2001@gmail.com";
            $subject = 'Invoice for your purchase service for astrologys';
            $message = $invoice_html;
            $headers = [
                "MIME-Version: 1.0",
                "Content-type: text/plain; charset=utf-8",
                "From: varniinfosoft@gmail.com",
            ];

            $headers = implode("\r\n", $headers);

            if (mail($to, $subject, $message, $headers)) {
                echo "
      <div class='card'>
            <div style='border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;'>
                <p class='pending-checkmark'>!</p>
            </div>
            <p>Transaction ID: " . $_POST['transactionId'] . "</p>
            <p>Amount: " . substr($_POST['amount'], 0, -2) . "</p>
            <p>Email : " . $email . "</p>
            <p>Service : " . $service_data . "</p>
            <h1 class='pending'>pending</h1> 
            <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
        </div> 
        <div></div>
        <div class='card' style='  background: white; 
    padding: 21px;
    border-radius: 4px;
    box-shadow: 0 2px 3px #C8D0D8;
    
    margin: 20px auto;'>
            <h2>Hi [User's Name],</h2>
            <p>I have sent the invoice to you via email. Please check your inbox.</p>
        </div>
    ";
            } else {
                echo "Failed to send invoice!";
            }


        }

    }
    ?>