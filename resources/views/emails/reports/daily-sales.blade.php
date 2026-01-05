<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; background-color: #f4f4f4;">
    <div style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center;">
            <h1 style="margin: 0; font-size: 28px;">📊 Daily Sales Report</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">{{ now()->format('F j, Y') }}</p>
        </div>

        <!-- Summary Cards -->
        <div style="padding: 30px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <!-- Total Orders -->
                <div style="background-color: #f8f9fa; border-radius: 8px; padding: 20px; border-left: 4px solid #28a745;">
                    <p style="margin: 0; color: #6c757d; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Total Products Sold</p>
                    <h2 style="margin: 10px 0 0 0; color: #28a745; font-size: 32px;">{{ $reportData->sum('quantity_sold') }}</h2>
                </div>

                <!-- Total Revenue -->
                <div style="background-color: #f8f9fa; border-radius: 8px; padding: 20px; border-left: 4px solid #007bff;">
                    <p style="margin: 0; color: #6c757d; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Total Revenue</p>
                    <h2 style="margin: 10px 0 0 0; color: #007bff; font-size: 32px;">${{ number_format($reportData->sum('total_revenue'), 2) }}</h2>
                </div>
            </div>

            @if(count($reportData) > 0)
            <!-- Top Products -->
            <div style="margin-bottom: 30px;">
                <h3 style="color: #495057; border-bottom: 2px solid #dee2e6; padding-bottom: 10px; margin-bottom: 20px;">
                    🏆 Top Selling Products
                </h3>
                <table style="width: 100%; border-collapse: collapse; background-color: #fff;">
                    <thead>
                        <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Product ID</th>
                            <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Product</th>
                            <th style="padding: 12px; text-align: center; font-weight: 600; color: #495057;">Quantity Sold</th>
                            <th style="padding: 12px; text-align: right; font-weight: 600; color: #495057;">Price</th>
                            <th style="padding: 12px; text-align: right; font-weight: 600; color: #495057;">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $product)
                            <tr style="border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 12px;">#{{ $product->product_id }}</td>
                                <td style="padding: 12px;">{{ $product->name }}</td>
                                <td style="padding: 12px; text-align: center;">{{ $product->quantity_sold }}</td>
                                <td style="padding: 12px; text-align: right; font-weight: 500; color: #28a745;">${{ number_format($product->price_at_time_of_purchase, 2) }}</td>
                                <td style="padding: 12px; text-align: right; font-weight: 500; color: #28a745;">${{ number_format($product->total_revenue, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Call to Action -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ config('app.url') }}/dashboard"
                   style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; padding: 14px 35px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px;">
                    View Full Dashboard
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8f9fa; padding: 20px; text-align: center; color: #6c757d; font-size: 14px; border-top: 1px solid #dee2e6;">
            <p style="margin: 0 0 10px 0;">This is an automated daily report from {{ config('app.name') }}</p>
            <p style="margin: 0;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
