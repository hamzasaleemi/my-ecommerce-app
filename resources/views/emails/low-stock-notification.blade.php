<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; border-radius: 8px; padding: 30px; margin-bottom: 20px;">
        <h1 style="color: #dc3545; margin-top: 0;">⚠️ Low Stock Alert</h1>
        <p style="font-size: 16px; color: #666;">
            Hello Admin,
        </p>
        <p style="font-size: 16px;">
            The following products have reached a low stock level and require your attention:
        </p>
    </div>

    @foreach ($products as $product)
            <div style="background-color: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; font-weight: bold; color: #495057;">Product ID:</td>
                    <td style="padding: 10px 0;">{{ $product['id'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: bold; color: #495057;">Product Name:</td>
                    <td style="padding: 10px 0;">{{ $product['name'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-weight: bold; color: #495057;">Current Stock:</td>
                    <td style="padding: 10px 0; color: #dc3545; font-weight: bold;">{{ $product['stock_quantity'] }}</td>
                </tr>
            </table>
        </div>
    @endforeach

    <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        <p style="margin: 0; color: #856404;">
            <strong>Action Required:</strong> Please restock these products as soon as possible to avoid running out of inventory.
        </p>
    </div>

    <div style="text-align: center; padding: 20px 0;">
        <a href="{{ config('app.url') }}/dashboard"
           style="display: inline-block; background-color: #007bff; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">
            View Dashboard
        </a>
    </div>

    <div style="text-align: center; color: #6c757d; font-size: 14px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
        <p>This is an automated notification from {{ config('app.name') }}</p>
        <p style="margin: 5px 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
