{{-- resources/views/emails/welcome-newsletter.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(to right, #ef380d, #d6320c); color: white; padding: 30px; border-radius: 10px; text-align: center; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 10px; margin-top: 20px; }
        .button { display: inline-block; background: #ef380d; color: white; padding: 12px 30px; text-decoration: none; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Afrojee Store!</h1>
            <p>Thank you for subscribing to our newsletter</p>
        </div>
        <div class="content">
            <h2>You're all set! 🎉</h2>
            <p>We're excited to have you as part of our community. You'll now receive:</p>
            <ul>
                <li>Exclusive deals and discounts</li>
                <li>New product announcements</li>
                <li>Special offers just for subscribers</li>
                <li>Updates on our latest collections</li>
            </ul>
            <a href="{{ url('/') }}" class="button">Start Shopping</a>
        </div>
        <div class="footer">
            <p>Don't want to receive these emails? <a href="{{ route('newsletter.unsubscribe', ['email' => '']) }}">Unsubscribe</a></p>
            <p>&copy; {{ date('Y') }} Afrojee Store. All rights reserved.</p>
        </div>
    </div>
</body>
</html>