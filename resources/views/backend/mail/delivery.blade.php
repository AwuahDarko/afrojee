<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { font-size: 20px; font-weight: bold; color: #2196F3; }
        .footer { font-size: 12px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Your Afrojee Order is on the Move!</div>
        <p>Hi {{ $data['customer_name'] }},</p>

        <p>Your order <strong>#{{ $data['order_id'] }}</strong> is now <strong>{{ $data['status'] }}</strong>.</p>

        {{-- <p>Estimated delivery: {{ $data['estimated_delivery_date'] }}</p> --}}

        <p>We’ll notify you once your package has been delivered.</p>

        <p>Thank you for choosing Afrojee!<br>— The Afrojee Team</p>

        <div class="footer">
            Questions? Contact our support at support@afrojee.com.
        </div>
    </div>
</body>
</html>
