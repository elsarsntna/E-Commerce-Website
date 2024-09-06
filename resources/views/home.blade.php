@extends('layouts.admin')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">


                            <h5 class="card-title text-primary">Welcome {{ Auth::user()->name }}!</h5>
                            <p class="mb-4">
                                Ecommerce Application Control Center
                            </p>

                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Revenue -->

    <!--/ Total Revenue -->

    <div class="row">
        <div class="col-lg-3 col-sm-6 mb-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="chart success"
                                class="rounded" />
                        </div>

                    </div>
                    <span class="fw-semibold d-block mb-1">Daily Turnover</span>
                    <h3 class="card-title mb-2">Rp. {{ number_format($totalRevenue) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}" alt="Credit Card"
                                class="rounded" />
                        </div>
                    </div>
                    <span class="d-block mb-1">New Customer (H-7)</span>
                    <h3 class="card-title text-nowrap mb-2">{{ $registeredUserCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-package"
                                    style="font-size: 24px;"></i></span>
                        </div>
                    </div>
                    <span class="d-block mb-1">Need To Submit</span>
                    <h3 class="card-title text-nowrap mb-2">{{ $shippingCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 mb-3 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card"
                                class="rounded" />
                        </div>

                    </div>
                    <span class="fw-semibold d-block mb-1">Total Products</span>
                    <h3 class="card-title text-nowrap mb-2">{{ $productCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">

            <div class="table-responsive text-nowrap ">
                <table class="table mt-4">
                    <h3>New Orders</h3>
                    <thead>
                        <tr>
                            <th>InvoiceID</th>
                            <th>Customer</th>
                            <th>Subtotal</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderNew as $row)
                            <tr>
                                <td><strong>{{ $row->invoice }}</strong></td>
                                <td>
                                    <strong>{{ $row->customer_name }}</strong><br>
                                    <label><strong>Phone:</strong> {{ $row->customer_phone }}</label><br>
                                    <label><strong>Address:</strong> {{ $row->customer_address }}
                                        {{ $row->district->name }} - {{ $row->district->city->name }},
                                        {{ $row->district->city->province->name }}</label>
                                </td>
                                <td>Rp. {{ number_format($row->subtotal) }}</td>
                                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                <td>
                                    {!! $row->status_label !!} <br>
                                    @if ($row->return_count > 0)
                                        <span class="badge rounded-pill bg-label-danger">

                                            <a href="{{ route('orders.return', $row->invoice) }} "
                                                class="text-danger">Request
                                                Return</a>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('orders.destroy', $row->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('orders.view', $row->invoice) }}"
                                            class="btn btn-warning btn-sm ">Show</a>
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">There is no orders data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
