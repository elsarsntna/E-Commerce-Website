@extends('layouts.admin')

@section('title')
    <title>Return Details</title>
@endsection

@section('content')
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Return Report</li>
        </ol>
        <div class="card">

            <div class="container-fluid">
                <div class="animated fadeIn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header mb-4 mt-2">
                                <h3 class="card-title ">
                                    <strong>Return Details</strong>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4><strong>Customer Details</strong></h4>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="30%">Customer Name</th>
                                                <td>{{ $order->customer_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $order->customer_phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Reason for Return</th>
                                                <td>{{ $order->return->reason }}</td>
                                            </tr>
                                            <tr>
                                                <th>Refund Account</th>
                                                <td>{{ $order->return->refund_transfer }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{!! $order->return->status_label !!}</td>
                                            </tr>
                                        </table>

                                        <!-- BAGIAN PENTING HANYA PADA FORM DIBAWAH -->
                                        @if ($order->return->status == 0)
                                            <form action="{{ route('orders.approve_return') }}"
                                                onsubmit="return confirm('Are you sure??');" method="post">
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <select name="status" class="form-control" required>
                                                        <option value="" disabled selected>Select...</option>
                                                        <option value="1">Accept</option>
                                                        <option value="2">Reject</option>
                                                    </select>
                                                    <div class="input-group-prepend mt-2">
                                                        <button class="btn btn-primary btn-sm">Return Process</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <h4><strong>Photo of Return Items</strong></h4>

                                        <img src="{{ asset('storage/return/' . $order->return->photo) }}"
                                            class="img-responsive" height="200" alt="">
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
