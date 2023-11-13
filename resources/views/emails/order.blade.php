<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #4CAF50;
        }

        address {
            margin-top: 20px;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .total {
            font-weight: bold;
        }

        .success {
            color: darkgreen;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="success">Thank You for Your Order!</h1>
    <h2>Your order (ID: #SS{{ $mailData['order']->id }})</h2>

    <h2>Shipping Address:</h2>
    <address>
        <strong>Customer:</strong> {{ $mailData['order']->full_name }}<br>
        <strong>Address:</strong> {{ $mailData['order']->address }} - {{ $mailData['order']->ward }} - {{ $mailData['order']->district }} - {{ $mailData['order']->province }}<br>
        <strong>Phone:</strong> {{ $mailData['order']->phone }}<br>
        <strong>Email:</strong> {{ $mailData['order']->email }}
    </address>

    <h2>Product Details:</h2>
    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Size</th>
            <th>Color</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mailData['order']->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->size }}</td>
                <td>{{ $item->color }}</td>
                <td>{{ number_format($item->price) }}₫</td>
                <td>{{ $item->qty }}</td>
                <td>{{ number_format($item->total) }}₫</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="5" class="text-right">Subtotal:</th>
            <td>{{ number_format($mailData['order']->subtotal) }}₫</td>
        </tr>

        <tr>
            <th colspan="5" class="text-right">Shipping:</th>
            <td>{{ number_format($mailData['order']->shipping) }}₫</td>
        </tr>
        <tr>
            <th colspan="5" class="text-right total">Grand Total:</th>
            <td>{{ number_format($mailData['order']->grand_total) }}₫</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
