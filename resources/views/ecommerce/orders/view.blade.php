@extends('layouts.ecommerce')

@section('title')
    <title>Order {{ $order->invoice }} - ElsaEcommerce</title>
@endsection

@section('content')
    <!--================Home Banner Area =================-->


    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Orders</p>
                        <h1> {{ $order->invoice }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Home Banner Area =================-->

    <div class="container">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="pt-80 pb-40">
                    @include('layouts.ecommerce.module.sidebar')
                </div>
            </div>

            <!-- Informasi Pesanan -->
            <div class="col-md-9">
                <div class="pt-80 pb-80">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card" style="border-radius: 15px">
                                <div class="card-header">
                                    <h4 class="card-title">Customer Data</h4>
                                </div>
                                <div class="card-body">
                                    <table>
                                        <tr>
                                            <td width="30%">InvoiceID</td>
                                            <td width="5%">:</td>
                                            <th><a href="{{ route('customer.order_pdf', $order->invoice) }}"
                                                    target="_blank"><strong>{{ $order->invoice }}</strong></a></th>
                                        </tr>
                                        <tr>
                                            <td width="30%">Full name</td>
                                            <td width="5%">:</td>
                                            <th>{{ $order->customer_name }}</th>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>:</td>
                                            <th>{{ $order->customer_phone }}</th>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td>:</td>
                                            <th>{{ $order->customer_address }}, {{ $order->district->name }}
                                                {{ $order->district->city->name }},
                                                {{ $order->district->city->province->name }}</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="border-radius: 15px">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        Payment

                                        @if ($order->status == 0)
                                            <a href="{{ url('member/payment?invoice=' . $order->invoice) }}"
                                                class="boxed-btn btn-sm float-right">Confirm </a>
                                        @endif
                                    </h4>
                                </div>
                                <div class="card-body">
                                    @if ($order->payment)
                                        <table>
                                            <tr>
                                                <td width="50%">Sender Name
                                                </td>
                                                <td width="5%">:</td>

                                                <td>{{ $order->payment->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Transfer Date</td>
                                                <td> :</td>
                                                <td>{{ $order->payment->transfer_date }}</td>
                                            </tr>
                                            <tr>
                                                <td>Transfer Amount</td>
                                                <td>:</td>
                                                <td>Rp {{ number_format($order->payment->amount) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Purpose of Transfer
                                                </td>
                                                <td>:</td>
                                                <td>{{ $order->payment->transfer_to }}</td>
                                            </tr>
                                            <tr>
                                                <td>Proof of Transfer</td>
                                                <td>:</td>
                                                <td>
                                                    <img src="{{ asset('storage/payment/' . $order->payment->proof) }}"
                                                        width="50px" height="50px" alt="">
                                                    <a href="{{ asset('storage/payment/' . $order->payment->proof) }}"
                                                        target="_blank">View Details</a>
                                                </td>
                                            </tr>
                                        </table>
                                    @else
                                        <h5 class="text-center">There is no payment data yet</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="card" style="border-radius: 15px">
                                <div class="card-header">
                                    <h4 class="card-title">Detail</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Project Name</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Weight</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($order->details as $row)
                                                    <tr>
                                                        <td>{{ $row->product->name }}</td>
                                                        <td>{{ number_format($row->price) }}</td>
                                                        <td>{{ $row->qty }} Item</td>
                                                        <td>{{ $row->weight }} gr</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">There is no data</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
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
@endsection
