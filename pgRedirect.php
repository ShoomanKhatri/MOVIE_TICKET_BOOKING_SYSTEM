<?php
// eSewa Sandbox Credentials
$MERCHANT_CODE = "EPAYTEST";
$SECRET_KEY = "8gBm/:&EnhH.1/q"; // Ensure correct key without extra spaces

// Transaction Details
$amount = $_POST['TXN_AMOUNT'];
// $tax_amount = $_POST['tax_amount'];
// echo $amount;
// echo $tax_amount;
$tax_amount = 10;
$total_amount = $amount + $tax_amount;
$transaction_uuid = uniqid(); // Generates a unique transaction ID
$product_code = "EPAYTEST";
$product_service_charge = 0;
$product_delivery_charge = 0;
$success_url = "http://localhost:5173/paymentsuccess"; 
$failure_url = "http://localhost:5173/paymentfailure"; 

// Correct signing data format based on eSewa’s documentation
$signed_field_names = "total_amount,transaction_uuid,product_code";
$signature_data = "total_amount={$total_amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";

// Generate HMAC SHA-256 signature
$hmac = hash_hmac("sha256", $signature_data, $SECRET_KEY, true);
$signature = base64_encode($hmac);

// echo "Generated Transaction UUID: " . $transaction_uuid . "<br>";
// echo "Generated Signature: " . $signature . "<br>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eSewa Sandbox Payment</title>
	<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="hidden"] {
            margin: 10px 0;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .note {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="container">
        <h2>Test eSewa Payment (Sandbox Mode)</h2>

        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <input type="hidden" name="amount" value="<?php echo $amount; ?>" required>
            <input type="hidden" name="tax_amount" value="<?php echo $tax_amount; ?>" required>
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>" required>
            <input type="hidden" name="transaction_uuid" value="<?php echo $transaction_uuid; ?>" required>
            <input type="hidden" name="product_code" value="<?php echo $product_code; ?>" required>
            <input type="hidden" name="product_service_charge" value="<?php echo $product_service_charge; ?>" required>
            <input type="hidden" name="product_delivery_charge" value="<?php echo $product_delivery_charge; ?>" required>
            <input type="hidden" name="success_url" value="<?php echo $success_url; ?>" required>
            <input type="hidden" name="failure_url" value="<?php echo $failure_url; ?>" required>
            <input type="hidden" name="signed_field_names" value="<?php echo $signed_field_names; ?>" required>
            <input type="hidden" name="signature" value="<?php echo $signature; ?>" required>
            
            <button type="submit">Submit Payment</button>
        </form>

        <div class="note">
            <p>Secure Payment via eSewa (Sandbox Mode).</p>
        </div>
    </div>
</body>
</html>
