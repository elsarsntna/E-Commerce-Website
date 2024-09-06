@extends('layouts.ecommerce')
@section('title')
    <title>Elsa ecommerce</title>
@endsection
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>See more Details</p>
                        <h1>{{ $product->name }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->



    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger text-center" style="border-radius: 15px;">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success text-center" style="border-radius: 15px;">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <p class="single-product-pricing">{{ $product->name }} </p>
                        <h3 style="color: #F28123;">Rp {{ number_format($product->price) }}</h3>
                        <p>{{ implode(' ', array_slice(explode('.', strip_tags($product->description)), 0, 2)) }}</p>
                        <p><strong>Categories: </strong>{{ $product->category->name }}</p>
                        <p><strong>Stock: </strong>{{ $product->stock }}</p>

                        <div class="single-product-form">
                            <form action="{{ route('front.cart') }}" method="POST">
                                @csrf
                                <input type="number" name="qty" min="1" id="sst" maxlength="12"
                                    value="1" title="Quantity:"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <input type="hidden" name="product_id" value="{{ $product->id }}" class="form-control">



                                <div class="card_area">

                                    <!-- UBAH JADI BUTTON -->
                                    <button class="btn_oren"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                                    <!-- UBAH JADI BUTTON -->
                                </div>
                            </form>
                        </div>
                        {{-- <h4>Share:</h4>
                        <ul class="product-share">
                            <li><a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://twitter.com/"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="https://plus.google.com/"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="https://www.linkedin.com/"><i class="fab fa-linkedin"></i></a></li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->


    <!-- more products -->
    <div class="more-products mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Detail</span> Products</h3>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Description
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            {!! $product->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Specification
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shipping-address-form">
                                            <div class="table-responsive">

                                                <table class="table table-hover table-bordered">
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <h6>Weight</h6>
                                                            </td>
                                                            <td>
                                                                <h6>{{ $product->weight }} gram</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6>Price</h6>
                                                            </td>
                                                            <td>
                                                                <h6>Rp {{ number_format($product->price) }}</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6>Categories</h6>
                                                            </td>
                                                            <td>
                                                                <h6>{{ $product->category->name }}</h6>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <h6>Stock</h6>
                                                            </td>
                                                            <td>
                                                                <h6>{{ $product->stock }}</h6>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- end more products -->
@endsection
