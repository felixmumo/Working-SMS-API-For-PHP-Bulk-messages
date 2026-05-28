```php
<?php

$responseMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mobile = trim($_POST['mobile']);
    $message = trim($_POST['message']);

    if (!preg_match('/^2547\d{8}$/', $mobile)) {

        $responseMessage = "Invalid phone number format.";

    } else {

        $curl = curl_init();

        $postData = array(
            'userid' => 'YOUR_USERNAME',
            'password' => 'YOUR_PASSWORD',
            'mobile' => $mobile,
            'msg' => $message,
            'senderid' => 'YOUR_SENDER_ID',
            'msgType' => 'text',
            'duplicatecheck' => 'true',
            'output' => 'json',
            'sendMethod' => 'quick'
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsportal.hostpinnacle.co.ke/SMSApi/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_HTTPHEADER => array(
                "apikey: YOUR_API_KEY",
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {

            $responseMessage = "cURL Error #: " . $err;

        } else {

            file_put_contents(
                "sms_response.json",
                $response
            );

            $responseMessage = $response;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS Sender</title>

    <style>

        body{
            font-family: Arial;
            background:#f4f4f4;
            padding:40px;
        }

        .container{
            width:400px;
            margin:auto;
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0px 0px 10px rgba(0,0,0,0.1);
        }

        input, textarea{
            width:100%;
            padding:12px;
            margin-top:10px;
        }

        button{
            width:100%;
            padding:12px;
            margin-top:15px;
            background:#0cb413;
            color:white;
            border:none;
            cursor:pointer;
        }

        .response{
            margin-top:20px;
            background:#f1f1f1;
            padding:10px;
        }

    </style>
</head>

<body>

<div class="container">

    <h2>Send SMS</h2>

    <form method="POST">

        <input
            type="text"
            name="mobile"
            placeholder="2547XXXXXXXX"
            required
        >

        <textarea
            name="message"
            rows="5"
            placeholder="Enter message"
            required
        ></textarea>

        <button type="submit">
            Send SMS
        </button>

    </form>

    <?php if(!empty($responseMessage)) { ?>

        <div class="response">

            <?php echo htmlspecialchars($responseMessage); ?>

        </div>

    <?php } ?>

</div>

</body>
</html>

Make sure to replace 'YOUR_USERNAME', 'YOUR_PASSWORD', 'YOUR_SENDER_ID', and 'YOUR_API_KEY' with your actual credentials before running the script. This code will create a simple web form to send SMS messages. When the form is submitted, it validates the phone number format and sends a POST request to the specified URL to send the SMS. The response is saved in a file named "sms_response.json" and displayed on the screen.    