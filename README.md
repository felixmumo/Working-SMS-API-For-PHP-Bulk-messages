# Working-SMS-API-For-PHP-Bulk-messages
HostPinnacle SMS API Integration Using PHP & XAMPP
Overview

This project demonstrates how to integrate the HostPinnacle SMS API using PHP and XAMPP.

The system allows you to:

Generate an API Key
Send SMS messages
Save API responses as JSON
Test SMS locally using XAMPP
Technologies Used
PHP
cURL
XAMPP
HTML & CSS
HostPinnacle SMS API
Requirements

Before starting, ensure you have:

XAMPP installed
Internet connection
HostPinnacle SMS account
Approved Sender ID
SMS credits
Project Structure
htdocs/
│
├── create_api_key.php
├── send_sms.php
├── apikey_response.json
└── sms_response.json
Step 1 — Install XAMPP

Download and install XAMPP:

Download XAMPP

After installation:

Open XAMPP Control Panel
Start Apache
Step 2 — Open htdocs Folder

Navigate to:

C:\xampp\htdocs\

All PHP files will be stored here.

Step 3 — Create API Key Generation File

Create a file named:

create_api_key.php

Paste the following code:

<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://smsportal.hostpinnacle.co.ke/SMSApi/apikey/create",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => http_build_query([
        'userid' => 'YOUR_USERNAME',
        'password' => 'YOUR_PASSWORD',
        'output' => 'json'
    ]),
    CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {

    echo "cURL Error #: " . $err;

} else {

    file_put_contents(
        "apikey_response.json",
        $response
    );

    echo "<h3>API Response</h3>";

    echo "<pre>";
    print_r(json_decode($response, true));
    echo "</pre>";

    echo "Response saved in apikey_response.json";
}

?>
Step 4 — Generate API Key

Open browser:

http://localhost/create_api_key.php

Expected response:

{
  "response": {
    "api": "apikey",
    "action": "create",
    "status": "success",
    "msg": "ApiKey Created successfully.",
    "code": "200"
  }
}
Step 5 — Retrieve API Key

Log into your SMS Portal dashboard:

HostPinnacle SMS Portal

Navigate to:

API Keys
Developer API
Integrations

Copy the generated API Key.

Example:

7ace91bcf2757f471869b779955c34ad0c0d1471
Step 6 — Create SMS Sending Page

Create a file named:

send_sms.php

Paste the following code:

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
Step 7 — Configure Credentials

Replace:

YOUR_USERNAME

with your SMS portal username.

Replace:

YOUR_PASSWORD

with your SMS portal password.

Replace:

YOUR_API_KEY

with your generated API key.

Replace:

YOUR_SENDER_ID

with your approved sender ID.

Step 8 — Run the SMS Sender

Open browser:

http://localhost/send_sms.php

Enter:

Phone number
Message

Click:

Send SMS
Example Test Number
254710557540
Example Message
Hello Felix, this is a test SMS from Greenlix Technologies.
JSON Response Files

The system automatically stores responses in:

API Key Response
apikey_response.json
SMS Sending Response
sms_response.json
Troubleshooting
Invalid Sender ID

Ensure the sender ID is approved in your SMS portal.

Authentication Failed

Confirm:

Username
Password
API Key
Invalid Phone Number

Use format:

2547XXXXXXXX
cURL Errors

Ensure:

Internet connection exists
Apache is running
PHP cURL extension is enabled
Features
SMS API Integration
API Key Generation
JSON Response Storage
Simple SMS UI
Phone Validation
Error Handling
Author

Felix Mumo
Greenlix Technologies

Call Us For:

Web Development
Rental Management Systems
Water Billing Systems
Fee Collection Systems
POS Systems
MPESA API Integrations
License

This project is open for educational and development purposes.
