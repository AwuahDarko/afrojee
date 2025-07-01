<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { font-size: 20px; font-weight: bold; color: #FF9800; }
        .footer { font-size: 12px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">New Order Placed on Afrojee</div>

        <p>Hello Admin,</p>

        <p>A new order has just been placed by <strong>{{ $data['customer_name'] }}</strong>.</p>

        <ul>
            <li><strong>Order ID:</strong> {{ $data['order_id'] }}</li>
            <li><strong>Customer Email:</strong> {{ $data['customer_email'] }}</li>
            <li><strong>Total:</strong> {{app_currency()}} {{ $data['total'] }}</li>
            <li><strong>Order Time:</strong> {{ $data['order_time'] }}</li>
        </ul>

        <p>Login to your dashboard to view more details.</p>

        <div class="footer">
            This is an automated notification from Afrojee.
        </div>
    </div>
</body>
</html>
