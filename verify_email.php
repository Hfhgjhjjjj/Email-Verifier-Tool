<?php
// Function to verify an email address using Kickbox API
function verifyEmail($email) {
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email address.";
    }
    
    // Set your Kickbox API key (replace with your actual API key)
    $apiKey =  $_ENV['live_ea90f011025ff2695d36ae6cfbd8a65859c0f4f84cf864becb9a8ed0e3e54e53'];  // Retrieve API key from environment variable
    
    if (!$apiKey) {
        return "API key is missing or invalid.";
    }
    
    // API endpoint
    $url = 'https://api.kickbox.com/v2/verify?email=' . urlencode($email) . '&apikey=' . $apiKey;
    
    // Initialize cURL session
    $curl = curl_init();
    
    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET'
    ));
    
    // Execute cURL request
    $response = curl_exec($curl);
    
    // Check for cURL errors
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        curl_close($curl);
        return "Error: $error";
    }
    
    // Close cURL session
    curl_close($curl);
    
    // Parse response JSON
    $result = json_decode($response, true);
    
    // Check response status
    if ($result && isset($result['result'])) {
        if ($result['result'] == 'undeliverable' || $result['result'] == 'unknown') {
            return "Email is not valid.";
        } elseif ($result['result'] == 'deliverable' || $result['result'] == 'risky') {
            return "Email is valid.";
        } else {
            return "Verification status: " . $result['result'];
        }
    } else {
        return "Failed to verify email.";
    }
}

// Check if email parameter is provided
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    echo verifyEmail($email);
} else {
    echo "Email parameter is missing.";
}
?>
