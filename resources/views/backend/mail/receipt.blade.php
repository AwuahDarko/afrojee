<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { font-size: 20px; font-weight: bold; color: #4CAF50; }
        .footer { font-size: 12px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Thank you for your purchase on Afrojee!</div>
        <p>Hi {{ $data['customer_name'] }},</p>

        <p>We’ve received your payment for the following order:</p>

        <ul>
            <li><strong>Order ID:</strong> {{ $data['order_id'] }}</li>
            <li><strong>Amount Paid:</strong> {{app_currency()}} {{ $data['amount'] }}</li>
            <li><strong>Payment Method:</strong> {{ $data['payment_method'] }}</li>
        </ul>

        <p>You will receive another email once your items have been shipped.</p>

        <p>Thanks for shopping with us!<br>— The Afrojee Team</p>

        <div class="footer">
            This is an automated message. Please do not reply directly.
        </div>
    </div>
</body>
</html>
