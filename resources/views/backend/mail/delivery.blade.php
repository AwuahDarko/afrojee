{{-- resources/views/emails/order-status.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Your Afro Jee Order Update</title>
</head>

<body
    style="margin:0; padding:0; background-color:#F8F7F4; font-family: Arial, sans-serif; color:#2E2E2E; line-height:1.6;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F8F7F4; padding:20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background-color:#ffffff; width:100%; max-width:600px; border-radius:8px; overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding:40px 20px 20px; border-bottom:1px solid #f0f0f0;">
                            <img src="https://afrojee.store/images/afro_logo.jpeg" alt="Afro Jee Logo" width="120"
                                style="display:block; border:0;">
                        </td>
                    </tr>

                    <!-- Title Section -->
                    <tr>
                        <td align="center" style="padding:40px 20px 20px;">
                            <h1 style="font-size:26px; font-weight:500; margin:0; color:#2E2E2E;">
                                Your Afro Jee Order is on the Move! 🚚
                            </h1>
                            <div style="width:60px; height:2px; background-color:#ef380d; margin:20px auto;"></div>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:20px 30px; background-color:#ffffff;">
                            <p style="font-size:16px; color:#666; margin:0 0 20px;">
                                Hi <strong>{{ $data['customer_name'] }}</strong>,
                            </p>
                            <p style="font-size:16px; color:#666; margin:0 0 15px;">
                                We’re excited to let you know that your order <strong>#{{ $data['order_id'] }}</strong>
                                is now
                                <strong style="color:#ef380d;">{{ ucfirst($data['status']) }}</strong>.
                            </p>

                            {{-- Optional estimated delivery --}}
                            {{--
                            <p style="font-size:16px; color:#666; margin:0 0 15px;">
                                Estimated delivery: <strong>{{ $data['estimated_delivery_date'] }}</strong>
                            </p>
                            --}}

                            <p style="font-size:16px; color:#666; margin:0 0 20px;">
                                You’ll receive another update once your package has been delivered. We appreciate your
                                patience and can’t wait for you to enjoy your Afro Jee products!
                            </p>

                            <p style="font-size:16px; color:#2E2E2E; margin:0;">
                                Thank you for choosing <strong>Afro Jee</strong>!<br>
                                — The Afro Jee Team
                            </p>
                        </td>
                    </tr>

                    <!-- CTA -->
                    <tr>
                        <td align="center" style="padding:40px 20px;">
                            <a href="https://afrojee.store/orders/{{ $data['order_id'] }}"
                                style="display:inline-block; background-color:#2E2E2E; color:#ffffff; padding:14px 36px; text-decoration:none; border-radius:40px; font-size:16px; font-weight:500;">
                                Track My Order
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding:30px 20px; background-color:#F8F7F4; border-top:1px solid #f0f0f0;">
                            <p style="font-size:15px; color:#666; margin:0 0 10px;">
                                Questions? Contact our support team at
                                <a href="mailto:support@afrojee.com"
                                    style="color:#ef380d; text-decoration:none;">support@afrojee.com</a>
                            </p>

                            <p style="font-size:14px; color:#999; margin-top:15px;">
                                © {{ date('Y') }} Afro Jee. All rights reserved.<br>
                                Barcelona, Spain | Accra, Ghana
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>