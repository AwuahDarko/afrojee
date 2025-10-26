{{-- resources/views/emails/payment-received-admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Received for Order #{{ $data['order_id'] }}</title>
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

                    <!-- Title -->
                    <tr>
                        <td align="center" style="padding:40px 20px 20px;">
                            <h1 style="font-size:26px; font-weight:500; margin:0; color:#2E2E2E;">
                                💰 Payment Received for Order <strong>#{{ $data['order_id'] }}</strong>
                            </h1>
                            <div style="width:60px; height:2px; background-color:#ef380d; margin:20px auto;"></div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding:20px 30px; background-color:#ffffff;">
                            <p style="font-size:16px; color:#666; margin:0 0 15px;">
                                Hello <strong>Admin</strong>,
                            </p>

                            <p style="font-size:16px; color:#666; margin:0 0 20px;">
                                A payment has been successfully made by <strong>{{ $data['customer_name'] }}</strong>.
                            </p>

                            <!-- Payment Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background-color:#F8F7F4; border-radius:6px; padding:15px 20px; margin-bottom:20px;">
                                <tr>
                                    <td style="font-size:15px; color:#2E2E2E; padding:8px 0;">
                                        <strong>Order ID:</strong> {{ $data['order_id'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px; color:#2E2E2E; padding:8px 0;">
                                        <strong>Amount:</strong> {{ app_currency() }} {{ $data['amount'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px; color:#2E2E2E; padding:8px 0;">
                                        <strong>Payment Method:</strong> {{ $data['payment_method'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px; color:#2E2E2E; padding:8px 0;">
                                        <strong>Payment Time:</strong> {{ $data['payment_time'] }}
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:16px; color:#666; margin:0;">
                                Please proceed to fulfill the order.
                                <br>Ensure prompt packaging and shipment to maintain customer satisfaction.
                            </p>
                        </td>
                    </tr>

                    <!-- CTA -->
                    <tr>
                        <td align="center" style="padding:40px 20px;">
                            <a href="https://afrojee.store/admin/orders/{{ $data['order_id'] }}"
                                style="display:inline-block; background-color:#2E2E2E; color:#ffffff; padding:14px 36px; text-decoration:none; border-radius:40px; font-size:16px; font-weight:500;">
                                View Order in Dashboard
                            </a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding:30px 20px; background-color:#F8F7F4; border-top:1px solid #f0f0f0;">
                            <p style="font-size:14px; color:#999; margin:0;">
                                This is an automated notification from <strong>Afro Jee</strong>.<br>
                                &copy; {{ date('Y') }} Afro Jee. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>