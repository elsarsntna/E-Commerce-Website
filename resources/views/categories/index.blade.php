@extends('layouts.admin')

@section('title')
    <title>Category</title>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item active">Category</li>
    </ol>
    <div class="row">
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label class="form-label" for="name">Category</label>
                            <input autocomplete="off" type="text" name="name" class="form-control"
                                placeholder="Name Category" required />
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card  mb-4">
                <h4 class="card-header">Category List</h4>
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


                    <div class="table-responsive text-nowrap ">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($category as $val)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ $val->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <form action="{{ route('category.destroy', $val->id) }}" method="post"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('category.edit', $val->id) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">There is no category data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination justify-content-end  mt-3">
                        {!! $category->links() !!}

                    </div>
                </div>
            </div>
        </div>
    @endsection
