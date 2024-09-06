@extends('layouts.ecommerce')

@section('title')
    <title>List Pesanan - ElsaEcommerce</title>
@endsection

@section('content')
    <!--================Home Banner Area =================-->
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>ecommerce</p>
                        <h1>Finish</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->
    <!--================End Home Banner Area =================-->


    <div class="container">

        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="pt-80 pb-80">
                    @include('layouts.ecommerce.module.sidebar')
                </div>
            </div>

            <!-- Informasi Pesanan -->
            <div class="col-md-9">
                <div class="pt-80 pb-80">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card " style="border-radius: 15px;">
                                <div class="card-header" style="background-color: #F28123;">
                                    <h4 class="card-title text-white">List Orders</h4>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    <div class="table-responsive">

                                        <table class="table table-hover table-bordered ">
                                            <thead>
                                                <tr>
                                                    <th>Invoice</th>
                                                    <th>Recipient</th>
                                                    <th>Phone</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($finishOrders as $row)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $row->invoice }}</strong><br>
                                                            @if ($row->return_count == 1)
                                                                <small>Return: {!! $row->return->status_label !!}</small>
                                                            @endif
                                                        </td>
                                                        <td>{{ $row->customer_name }}</td>
                                                        <td>{{ $row->customer_phone }}</td>
                                                        <td>{{ number_format($row->subtotal) }}</td>
                                                        <td>{!! $row->status_label !!}</td>

                                                        <td>{{ $row->created_at }}</td>
                                                        <td>
                                                            <form action="{{ route('customer.order_accept') }}"
                                                                class="form-inline"
                                                                onsubmit="return confirm('Kamu Yakin?');" method="post">
                                                                @csrf

                                                                <a href="{{ route('customer.view_order', $row->invoice) }}"
                                                                    class="btn btn-primary btn-sm mr-1"
                                                                    style="border-radius: 50px">Detail</a>
                                                                <input type="hidden" name="order_id"
                                                                    value="{{ $row->id }}">
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">There is no data</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="float-right">
                                        {!! $finishOrders->links() !!}
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
