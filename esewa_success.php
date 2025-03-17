<?php
if (!isset($_GET['transaction_uuid'], $_GET['amount'], $_GET['status'])) {
    die("Invalid request.");
}

// Retrieve Response
$transaction_uuid = $_GET['transaction_uuid'];
$amount = $_GET['amount'];
$status = $_GET['status'];

if ($status == "COMPLETE") {
    // Verify transaction with eSewa API
    $MERCHANT_CODE = "EPAYTEST";
    $verification_url = "https://rc-epay.esewa.com.np/api/epay/verify";
    $data = [
        'transaction_uuid' => $transaction_uuid,
        'product_code' => $MERCHANT_CODE,
    ];

    // Send Verification Request
    $ch = curl_init($verification_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    // Check response
    $response_data = json_decode($response, true);
    if ($response_data['status'] == "COMPLETE") {
        echo "Transaction Verified Successfully!";
        // Store payment details in the database (optional)
    } else {
        echo "Transaction Verification Failed!";
    }
} else {
    echo "Payment Failed!";
}
?>
