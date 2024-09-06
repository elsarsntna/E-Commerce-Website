@extends('layouts.admin')

@section('title')
    <title>Order Report</title>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Order Report</li>
    </ol>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title d-flex justify-content-between align-items-center">
                Order Report
            </h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-2">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <form action="{{ route('report.order') }}" method="get">
                        <div class="input-group mb-3">
                            <input type="text" id="created_at" name="date" class="form-control me-2">

                            <div class="input-group-append">
                                <button class="btn btn-secondary me-2" type="submit">Filter</button>
                            </div>
                            <div class="input-group-append">
                                <a target="_blank" class="btn btn-primary ml-2" id="exportpdf">Export PDF</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>InvoiceID</th>
                            <th>Customer</th>
                            <th>Subtotal</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">There is no order data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination justify-content-end  mt-4">
                {!! $orders->links() !!}
            </div>
        </div>
    </div>
@endsection



<!-- KITA GUNAKAN LIBRARY DATERANGEPICKER -->
@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        //KETIKA PERTAMA KALI DI-LOAD MAKA TANGGAL NYA DI-SET TANGGAL SAA PERTAMA DAN TERAKHIR DARI BULAN SAAT INI
        $(document).ready(function() {
            let start = moment().startOf('month')
            let end = moment().endOf('month')

            //KEMUDIAN TOMBOL EXPORT PDF DI-SET URLNYA BERDASARKAN TGL TERSEBUT
            $('#exportpdf').attr('href', '/administrator/ReportOrder/pdf/' + start.format('YYYY-MM-DD') + '+' +
                end.format('YYYY-MM-DD'))

            //INISIASI DATERANGEPICKER
            $('#created_at').daterangepicker({
                startDate: start,
                endDate: end
            }, function(first, last) {
                //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
                $('#exportpdf').attr('href', '/administrator/ReportOrder/pdf/' + first.format(
                    'YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
            })
        })
    </script>
@endsection()
