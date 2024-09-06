@extends('layouts.admin')

@section('title')
    <title>Edit Category</title>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Home</a></li>
        <li class="breadcrumb-item active">Edit Category</li>
    </ol>
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" class="form-control" id="name" name="name"
                                    value="{{ $category->name }}" required>
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
