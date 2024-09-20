<?php
// Manually setting the headers (you may replace this with real headers from your environment)
$headers = [
    "Content-Type: application/json", // Example header, adjust as needed
    // Add more headers if required
];

// Target URL where you want to forward the POST request
$targetUrl = "https://orange-invention-jj56g97qp6gg3q9vj-7569.app.github.dev/api/messages";

// Initialize cURL session
$ch = curl_init($targetUrl);

// Retrieve POST data
$postData = file_get_contents('php://input'); // Get raw POST data

// Prepare cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // Forward the raw POST data
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Use manually set headers

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
