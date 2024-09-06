@extends('layouts.admin')

@section('title')
    <title>Edit Product</title>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Home</a></li>
        <li class="breadcrumb-item active">Edit Product</li>
    </ol>
    <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Product</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="name">Name Product</label>
                            <input type="text" autocomplete="off" name="name" class="form-control"
                                value="{{ $product->name }}" required />
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category_id">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="" disabled selected>Select Category</option>
                                @foreach ($category as $row)
                                    <option value="{{ $row->id }}"
                                        {{ $product->category_id == $row->id ? 'selected' : '' }}>{{ $row->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('category_id') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea name="description" autocomplete="off" id="description" class="form-control">{{ $product->description }}</textarea>
                            <p class="text-danger">{{ $errors->first('description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ $product->status == '1' ? 'selected' : '' }}>Publish</option>
                                <option value="0" {{ $product->status == '0' ? 'selected' : '' }}>Draft</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('status') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stock">Stock</label>
                            <input type="number" autocomplete="off" name="stock" class="form-control"
                                value="{{ $product->stock }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                required>
                            <p class="text-danger">{{ $errors->first('stock') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="price">Price</label>
                            <input type="number" autocomplete="off" name="price" class="form-control"
                                value="{{ $product->price }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                required>
                            <p class="text-danger">{{ $errors->first('price') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="weight">Weight</label>
                            <input type="number" autocomplete="off" name="weight" class="form-control"
                                value="{{ $product->weight }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                required>
                            <p class="text-danger">{{ $errors->first('weight') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="image">Image Product</label>
                            <br>
                            <!--  TAMPILKAN GAMBAR SAAT INI -->
                            <img src="{{ asset('storage/products/' . $product->image) }}" width="100px" height="100px"
                                alt="{{ $product->name }}" style="border-radius: 10px;">
                            <hr>
                            <input type="file" name="image" class="form-control">
                            <p><strong>Leave blank if you do not want to change the image</strong></p>
                            <p class="text-danger">{{ $errors->first('image') }}</p>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-s">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection






@section('js')
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
