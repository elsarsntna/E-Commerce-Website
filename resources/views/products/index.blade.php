@extends('layouts.admin')

@section('title')
    <title>Product</title>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Product</li>
    </ol>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title d-flex justify-content-between align-items-center">
                Product List
                <div>
                    <a href="{{ route('product.create') }}" class="btn btn-outline-primary btn-sm ">Add Product</a>
                </div>
            </h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif

            <div class="row mb-2">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <form action="{{ route('product.index') }}" method="get" class="d-flex">
                        <input class="form-control me-2" type="text" autocomplete="off" name="q"
                            class="form-control" placeholder="Search Product..." value="{{ request()->q }}">
                        <button class="btn btn-primary btn-sm " type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive text-nowrap ">
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($product as $row)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/products/' . $row->image) }}" width="100px" height="100px"
                                        alt="{{ $row->name }}" style="border-radius: 10px;">
                                </td>
                                <td>
                                    <strong>{{ $row->name }}</strong><br>
                                    <label>Category: <span
                                            class="badge rounded-pill bg-label-info">{{ $row->category->name }}</span></label><br>
                                    <label>Weight: <span class="badge rounded-pill bg-label-danger">{{ $row->weight }}
                                            gr</span></label><br>
                                    <label>Stock: <span
                                            class="badge rounded-pill bg-label-warning">{{ $row->stock }}</span></label>
                                </td>
                                <td>Rp {{ number_format($row->price) }}</td>
                                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                <td>{!! $row->status_label !!}</td>
                                <td>
                                    <form action="{{ route('product.destroy', $row->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('product.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        {{-- <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button> --}}
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">There is no Product data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination justify-content-end  mt-4">
                {!! $product->links() !!}
            </div>

        </div>
    </div>
@endsection
