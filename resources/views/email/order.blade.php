<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        h2 {
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .text-right {
            text-align: right;
        }
        .total-row th, .total-row td {
            border-top: 2px solid #333;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #777;
        }
        @media (max-width: 600px) {
            th, td {
                padding: 5px;
                border: 1px solid #ddd;
                text-align: left;
            }
            .footer {
                margin-top: 10px;
            }
            .container {
                width: 90%;
                padding: 10px;
            }
        }
        .address {
            font-style: normal;
            font-size: 14px;
            line-height: 1.5;
            color: #3c3939;
            margin-bottom: 20px;
            text-transform: lowercase;
        }
        .address samp {
            font-size: 16px;
            font-style: normal;
            color: #000000d5;
            text-transform:capitalize;
        }
        @media (max-width: 600px) {
            .address {
                font-size: 12px;
                line-height: 1.4;
                margin-bottom: 10px;
                font-style: normal;
                text-transform: lowercase;
            }
            .address samp {
                font-size: 14px;
                font-style: normal;
                text-transform:capitalize;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @if ($userType == 'customer')
            <h1>Thank you for your order</h1>
            <h2>Your Order ID: {{ $order->id }}</h2>
        @else
            <h1>New order received</h1>
            <h2>Customer Order ID: {{ $order->id }}</h2>
        @endif
        <p class="address">
            {{ $order->first_name . " " . $order->last_name }} <br>
            Address: <samp>{{ $order->address }}<br>
            {{ $order->city }}, {{ $order->zip }} {{ getCountryInfo($order->country_id)->name }}<br></samp>
        </p>

        <h2>Order Details</h2>
        <table>
            <thead>
                <tr>
                    <th data-title="Product">Product</th>
                    <th data-title="Price" width="100">Price</th>
                    <th data-title="Qty" width="100">Qty</th>
                    <th data-title="Total" width="100">Total</th>
                </tr>
            </thead>
            <tbody>
                @if ($order->items && $order->items->isNotEmpty())
                    @foreach ($order->items as $item)
                        <tr>
                            <td data-title="Product">{{ $item->name }}</td>
                            <td data-title="Price">&#8377; {{ number_format($item->price, 2) }}</td>
                            <td data-title="Qty">{{ $item->qty }}</td>
                            <td data-title="Total">&#8377; {{ number_format($item->price * $item->qty, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No items found for this order.</td>
                    </tr>
                @endif
                <tr>
                    <th colspan="3" class="text-right">Subtotal:</th>
                    <td>&#8377; {{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Discount {{ $order->coupon_code ? '(' . $order->coupon_code . ')' : '' }}:</th>
                    <td>&#8377; {{ number_format($order->discount, 2) }}</td>
                </tr>
                <tr>
                    <th colspan="3" class="text-right">Shipping:</th>
                    <td>&#8377; {{ number_format($order->shipping, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <th colspan="3" class="text-right">Grand Total:</th>
                    <td>&#8377; {{ number_format($order->grand_total, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>If you have any questions about your order, please contact us at support@example.com.</p>
            <p>Thank you for shopping with us!</p>
        </div>
    </div>
</body>
</html>
