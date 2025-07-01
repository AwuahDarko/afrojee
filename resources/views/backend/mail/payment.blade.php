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
        <div class="header">Payment Received for Order #{{ $data['order_id'] }}</div>

        <p>Hello Admin,</p>

        <p>A payment has been successfully made by <strong>{{ $data['customer_name'] }}</strong>.</p>

        <ul>
            <li><strong>Order ID:</strong> {{ $data['order_id'] }}</li>
            <li><strong>Amount:</strong> GHS {{ $data['amount'] }}</li>
            <li><strong>Payment Method:</strong> {{ $data['payment_method'] }}</li>
            <li><strong>Payment Time:</strong> {{ $data['payment_time'] }}</li>
        </ul>

        <p>Please proceed to fulfill the order.</p>

        <div class="footer">
            This is an automated notification from Afrojee.
        </div>
    </div>
</body>
</html>
