<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        /* Gaya CSS untuk laporan */

        @page {
            size: landscape;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        .header p {
            font-size: 16px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="header mb-6">
        <h1>Ecommerce elsarsntna</h1>
        <p>JL. Rahasia PT.BAHAGIA JAWA BARAT NO.001 </p>
        <p>Telp: (021)12345678 | Email: elsarstna12@gmail.com</p>
        <hr>
    </div>

    <h5>Period Order Report ({{ $date[0] }} - {{ $date[1] }})</h5>
    <br>
    <table>
        <thead>

            <th>InvoiceID</th>
            <th>Customer</th>
            <th>Subtotal</th>
            <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse ($orders as $row)
                <tr>
                    <td><strong>{{ $row->invoice }}</strong></td>
                    <td>
                        <strong>{{ $row->customer_name }}</strong><br>
                        <label><strong>Phone:</strong> {{ $row->customer_phone }}</label><br>
                        <label><strong>Address:</strong> {{ $row->customer_address }}
                            {{ $row->customer->district->name }} - {{ $row->customer->district->city->name }},
                            {{ $row->customer->district->city->province->name }}</label>
                    </td>
                    <td>Rp {{ number_format($row->subtotal) }}</td>
                    <td>{{ $row->created_at->format('d-m-Y') }}</td>
                </tr>

                @php $total += $row->subtotal @endphp
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Total</td>
                <td>Rp {{ number_format($total) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
