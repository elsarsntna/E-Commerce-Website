@extends('layouts.ecommerce')

@section('title')
    <title>Dashboard - ElsaEcommerce</title>
@endsection

@section('content')
    <!--================Home Banner Area =================-->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>ecommerce</p>
                        <h1>Dashboard</h1>
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
                <div class="pt-80 pb-80">
                    @include('layouts.ecommerce.module.sidebar')
                </div>
            </div>

            <!-- Informasi Orders -->
            <div class="col-md-9">
                <div class="pt-80 pb-80">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                            <a href="{{ route('unpaid.orders') }}" style="text-decoration: none; color: inherit;">
                                <div class="list-box d-flex align-items-center">
                                    <div class="list-icon">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Unpaid</h3>
                                        <p>Rp {{ number_format($orders[0]->pending) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                            <a href="{{ route('confirm.orders') }}" style="text-decoration: none; color: inherit;">
                                <div class="list-box d-flex justify-content-start align-items-center">
                                    <div class="list-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Waiting</h3>
                                        <p>{{ $orders[0]->waiting }} Orders</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                            <a href="{{ route('paking.orders') }}" style="text-decoration: none; color: inherit;">
                                <div class="list-box d-flex justify-content-start align-items-center">
                                    <div class="list-icon">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Paking</h3>
                                        <p>{{ $orders[0]->paking }} Orders</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="mt-4 col-lg-4 col-md-6 mb-4 mb-lg-0">
                            <a href="{{ route('shipping.orders') }}" style="text-decoration: none; color: inherit;">
                                <div class="list-box d-flex align-items-center">
                                    <div class="list-icon">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Shipping</h3>
                                        <p>{{ $orders[0]->shipping }} Orders</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0 mt-4">
                            <a href="{{ route('finish.orders') }}" style="text-decoration: none; color: inherit;">
                                <div class="list-box d-flex justify-content-start align-items-center">
                                    <div class="list-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="content">
                                        <h3>Completed</h3>
                                        <p>{{ $orders[0]->completeOrder }} Orders</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
