{{-- resources/views/emails/contact-form.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(to right, #ef380d, #d6320c); color: white; padding: 20px; border-radius: 10px; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .label { font-weight: bold; color: #ef380d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        <div class="content">
            <p><span class="label">Name:</span> {{ $contactData['name'] }}</p>
            <p><span class="label">Email:</span> {{ $contactData['email'] }}</p>
            <p><span class="label">Message:</span></p>
            <p>{{ $contactData['message'] }}</p>
            <hr>
            <p style="color: #666; font-size: 12px;">Received: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>
    </div>
</body>
</html>