@extends('layouts.admin')

@section('title')
    <title>Order Details</title>
@endsection

@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Order Details</li>
        </ol>
        <div class="card">
            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card-header mt-3">
                                <h3 class="card-title ">
                                    <strong>Order Details</strong>
                                    <!-- TOMBOL UNTUK MENERIMA PEMBAYARAN -->
                                    <div class="float-end">
                                        <!-- TOMBOL INI HANYA TAMPIL JIKA STATUSNYA 1 DARI ORDER DAN 0 DARI PEMBAYARAN -->
                                        @if ($order->status == 1 && $order->payment->status == 0)
                                            <a href="{{ route('orders.approve_payment', $order->invoice) }}"
                                                class="btn btn-primary btn-sm">Accept Payment</a>
                                        @endif
                                    </div>
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!-- Detail Pelanggan -->
                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="card-title">Customer Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th width="40%">Customer Name</th>
                                                        <td>{{ $order->customer_name }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Phone</th>
                                                        <td>{{ $order->customer_phone }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Address</th>
                                                        <td>{{ $order->customer_address }}
                                                            {{ $order->district->name }} -
                                                            {{ $order->district->city->name }},
                                                            {{ $order->district->city->province->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Order Status</th>
                                                        <td>{!! $order->status_label !!}</td>
                                                    </tr>
                                                    <!-- FORM INPUT RESI HANYA AKAN TAMPIL JIKA STATUS LEBIH BESAR 1 -->
                                                    @if ($order->status > 1)
                                                        <tr>
                                                            <th>Receipt Number</th>
                                                            <td>
                                                                @if ($order->status == 2)
                                                                    <form action="{{ route('orders.shipping') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <div class="input-group">
                                                                            <input type="hidden" name="order_id"
                                                                                value="{{ $order->id }}">
                                                                            <input type="text" name="tracking_number"
                                                                                autocomplete="off"
                                                                                placeholder="Enter Receipt Number"
                                                                                class="form-control me-2" required>
                                                                            <div class="input-group-append">
                                                                                <button class="btn btn-secondary"
                                                                                    type="submit">Send</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                @else
                                                                    {{ $order->tracking_number }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail Pembayaran -->
                                    <div class="col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="card-title">Payment Details</h5>
                                            </div>
                                            <div class="card-body">
                                                @if ($order->status != 0)
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th width="40%">Sender Name</th>
                                                            <td>{{ $order->payment->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Destination Bank</th>
                                                            <td>{{ $order->payment->transfer_to }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Transfer Date</th>
                                                            <td>{{ $order->payment->transfer_date }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Proof of Payment</th>
                                                            <td>

                                                                <a target="_blank"
                                                                    href="{{ asset('storage/payment/' . $order->payment->proof) }}">Show</a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status</th>
                                                            <td>{!! $order->payment->status_label !!}</td>
                                                        </tr>
                                                    </table>
                                                @else
                                                    <h5 class="text-center">Payment Not Confirmed</h5>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail Produk -->
                                    <div class="col-md-12">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="card-title">Product Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-bordered table-hover">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Weight</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                    @foreach ($order->details as $row)
                                                        <tr>
                                                            <td>{{ $row->product->name }}</td>
                                                            <td>{{ $row->qty }}</td>
                                                            <td>Rp {{ number_format($row->price) }}</td>
                                                            <td>{{ $row->weight }} gr</td>
                                                            <td>Rp {{ $row->qty * $row->price }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
