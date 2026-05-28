
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
Make sure to replace 'YOUR_USERNAME' and 'YOUR_PASSWORD' with your actual credentials before running the script. This code will send a POST request to the specified URL to create an API key, and it will save the response in a file named "apikey_response.json". It also prints the response in a readable format on the screen.