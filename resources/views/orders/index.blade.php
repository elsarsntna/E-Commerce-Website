@extends('layouts.admin')

@section('title')
    <title>Orders</title>
@endsection


@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Orders</li>
    </ol>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Orders List
            </h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- FORM UNTUK FILTER DAN PENCARIAN -->
            <form action="{{ route('orders.index') }}" method="get">
                <div class="row mb-2">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>

                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <select name="status" class="form-control mr-3">
                                <option value="" disabled selected>Select Status ...</option>
                                <option value="0">New</option>
                                <option value="1">Comfirm</option>
                                <option value="2">Process</option>
                                <option value="3">Shipping</option>
                                <option value="4">Finished</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3">
                            <input class="form-control me-2" autocomplete="off" type="text" name="q"
                                placeholder="Search Orders..." value="{{ request()->q }}">
                            <div>
                                <button class="btn btn-outline-primary btn-s" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>


            <div class="table-responsive text-nowrap ">
                <table class="table mt-4">
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
                        @forelse ($orders as $row)
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
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this orders?')">Delete</button>
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
            <div class="pagination justify-content-end  mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
