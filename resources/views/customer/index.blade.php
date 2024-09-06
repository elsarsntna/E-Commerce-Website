@extends('layouts.admin')

@section('title')
    <title>Customer</title>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Customer</li>
    </ol>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Customer List
            </h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif


            <div class="table-responsive text-nowrap ">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataCustomer as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->phone_number }}</td>
                                <td>{!! $row->status_label !!}</td>
                                <td>
                                    <a href="{{ route('customer.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">There is no orders data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination justify-content-end  mt-4">
                {{ $dataCustomer->links() }}
            </div>
        </div>
    </div>
@endsection
