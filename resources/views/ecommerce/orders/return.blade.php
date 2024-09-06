@extends('layouts.ecommerce')

@section('title')
    <title>Return {{ $order->invoice }} - ElsaEcommerce</title>
@endsection

@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Return</p>
                        <h1>{{ $order->invoice }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->


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

                                    @if (session('error'))
                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                    @endif

                                    <form action="{{ route('customer.return', $order->id) }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="billing-address">

                                            <input type="hidden" name="_method" value="PUT">
                                            <div>
                                                <label for="">Reason for return</label>
                                                <textarea autocomplete="off" name="reason" cols="5" rows="5" required></textarea>
                                            </div>
                                            <div>
                                                <label for="">Refund Transfer</label>
                                                <input autocomplete="off" type="text" name="refund_transfer"
                                                    value="{{ number_format($order->subtotal) }}" readonly>
                                            </div>
                                            <div>
                                                <label for="">Image</label>
                                                <input type="file" name="photo" required>
                                            </div>
                                            <button class="btn_oren">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
