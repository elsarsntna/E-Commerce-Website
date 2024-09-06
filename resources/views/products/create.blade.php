@extends('layouts.admin')

@section('title')
    <title>Add Product</title>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Home</a></li>
        <li class="breadcrumb-item active">Product</li>
    </ol>
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Product</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="name">Name Product</label>
                            <input type="text" autocomplete="off" name="name" class="form-control"
                                value="{{ old('name') }}" placeholder="Name Product" required />
                            <p class="text-danger">{{ $errors->first('name') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category_id">Category</label>
                            <select name="category_id" class="form-control">
                                <option value=""disabled selected>Select Category</option>
                                @foreach ($category as $row)
                                    <option value="{{ $row->id }}"
                                        {{ old('category_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('category_id') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea name="description" autocomplete="off" id="description" class="form-control">{{ old('description') }}</textarea>
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
                                <option value=""disabled selected>Select Status</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Publish</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('status') }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="stock">Stock</label>
                            <input type="number" autocomplete="off" name="stock" class="form-control"
                                value="{{ old('stock') }}" placeholder="Stock" min="1"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            <p class="text-danger">{{ $errors->first('stock') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="price">Price</label>
                            <input type="number" autocomplete="off" name="price" class="form-control"
                                value="{{ old('price') }}" placeholder="Price" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            <p class="text-danger">{{ $errors->first('price') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="weight">Weight</label>
                            <input type="number" autocomplete="off" name="weight" class="form-control"
                                value="{{ old('weight') }}" placeholder="Weight (gr)"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            <p class="text-danger">{{ $errors->first('weight') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="image">Image Product</label>
                            <input type="file" name="image" class="form-control" value="{{ old('image') }}" required>
                            <p class="text-danger">{{ $errors->first('image') }}</p>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary btn-sm">Add Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection


<!-- PADA ADMIN LAYOUTS, TERDAPAT YIELD JS YANG BERARTI KITA BISA MEMBUAT SECTION JS UNTUK MENAMBAHKAN SCRIPT JS JIKA DIPERLUKAN -->
@section('js')
    <!-- LOAD CKEDITOR -->
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        //TERAPKAN CKEDITOR PADA TEXTAREA DENGAN ID DESCRIPTION
        CKEDITOR.replace('description');
    </script>
@endsection
