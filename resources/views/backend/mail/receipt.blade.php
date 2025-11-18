{{-- resources/views/emails/payment-confirmation-customer.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thank You for Your Purchase on Afro Jee!</title>
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
                                🎉 Thank You for Your Purchase!
                            </h1>
                            <div style="width:60px; height:2px; background-color:#ef380d; margin:20px auto;"></div>
                            <p style="font-size:17px; color:#666; margin:0;">
                                Your payment has been successfully received.
                            </p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding:20px 30px; background-color:#ffffff;">
                            <p style="font-size:16px; color:#666; margin:0 0 20px;">
                                Hi <strong>{{ $data['customer_name'] }}</strong>,
                            </p>

                            <p style="font-size:16px; color:#666; margin:0 0 20px;">
                                We’ve received your payment for the following order:
                            </p>

                            <!-- Order Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background-color:#F8F7F4; border-radius:6px; padding:15px 20px; margin-bottom:20px;">
                                <tr>
                                    <td style="font-size:15px; color:#2E2E2E; padding:8px 0;">
                                        <strong>Order ID:</strong> {{ $data['order_id'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px; color:#2E2E2E; padding:8px 0;">
                                        <strong>Amount Paid:</strong> {{ app_currency() }} {{ $data['amount'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px; color:#2E2E2E; padding:8px 0;">
                                        <strong>Payment Method:</strong> {{ $data['payment_method'] }}
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:16px; color:#666; margin:0 0 20px;">
                                You’ll receive another email once your items have been shipped.
                                We’ll keep you updated every step of the way.
                            </p>

                            <p style="font-size:16px; color:#2E2E2E; margin:0;">
                                Thanks for shopping with us!<br>
                                — The Afro Jee Team
                            </p>
                        </td>
                    </tr>

                    <!-- CTA -->
                    <tr>
                        <td align="center" style="padding:40px 20px;">
                            <a href="https://afrojee.store/orders/{{ $data['order_id'] }}"
                                style="display:inline-block; background-color:#2E2E2E; color:#ffffff; padding:14px 36px; text-decoration:none; border-radius:40px; font-size:16px; font-weight:500;">
                                View My Order
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding:30px 20px; background-color:#F8F7F4; border-top:1px solid #f0f0f0;">
                            <p style="font-size:14px; color:#999; margin:0;">
                                This is an automated message. Please do not reply directly.<br>
                                Need help? Contact <a href="mailto:info@afrojee.store"
                                    style="color:#ef380d; text-decoration:none;">info@afrojee.store</a>.
                            </p>
                            <p style="font-size:14px; color:#999; margin-top:15px;">
                                © {{ date('Y') }} Afro Jee. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>