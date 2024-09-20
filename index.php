<?php
// Target URL where you want to forward the POST request
//$targetUrl = "https://sap-ticket-tracker-bot.vercel.app/api/messages";

//$targetUrl = "https://sap-ticket-tracker-bot.onrender.com/api/messages";

//test
$targetUrl = "https://orange-invention-jj56g97qp6gg3q9vj-7569.app.github.dev/api/messages";

// Initialize cURL session
$ch = curl_init($targetUrl);

// Retrieve POST data
$postData = file_get_contents('php://input'); // Get raw POST data

// Get the incoming headers
$headers = getallheaders();
unset($headers['Host']); // Remove Host header if present, as it is not needed

// Prepare cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // Forward the raw POST data
curl_setopt($ch, CURLOPT_HTTPHEADER, array_map(
    function ($key, $value) {
        return "$key: $value";
    },
    array_keys($headers),
    $headers
));

// Execute the POST request and capture the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    http_response_code(500); // Set response code to 500 for server error
    echo 'cURL error: ' . curl_error($ch);
    exit();
}

// Get the response code from the target URL
$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Close cURL session
curl_close($ch);

// Set the same HTTP response code and content type as received
http_response_code($responseCode);

// Output the response from the target URL
echo $response;
?>
