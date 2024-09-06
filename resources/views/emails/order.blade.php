<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Order Has Been Shipped - Invoice: {{ $order->invoice }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        h2 {
            color: #3498db;
        }

        p {
            color: #555;
        }

        strong {
            color: #2ecc71;
        }
    </style>
</head>

<body>
    <h2>Hello, {{ $order->customer->name }}!</h2>
    <p>We're excited to inform you that your order has been shipped! Here are the details:</p>

    <ul>
        <li><strong>Invoice Number:</strong> {{ $order->invoice }}</li>
        <li><strong>Tracking Number:</strong> {{ $order->tracking_number }}</li>
    </ul>

    <p>Your items are on their way to you. You can track your order using the provided tracking number. If you have any
        questions or concerns, feel free to contact our customer support.</p>

    <p>Thank you for choosing us. We appreciate your business!</p>
</body>

</html>
