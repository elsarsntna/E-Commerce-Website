@extends('layouts.ecommerce')
@section('title')
    <title>Product - ElsaEcommerce</title>
@endsection
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>ecommerce</p>
                        <h1>Product</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- products -->


    <div class="product-section mt-150 mb-150">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            <li class="active" data-filter="*">All</li>
                            @foreach ($categories as $category)
                                <li data-filter=".{{ Str::slug($category->name) }}">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>


            <div class="row product-lists" id="product-lists">
                @forelse($products as $row)
                    @if ($row->status == 1 && $row->stock > 0)
                        <div class="col-lg-4 col-md-6 text-center product-item {{ Str::slug($row->category->name) }}">
                            <div class="single-product-item">
                                <div class="product-image">
                                    <a href="{{ url('/product/' . $row->slug) }}">
                                        <img src="{{ $row->image != '' ? asset('storage/products/' . $row->image) : asset('assets/img/icons/brands/image-not-found.jpg') }}"
                                            alt="{{ $row->name }}">
                                    </a>
                                </div>
                                <h4>{{ $row->name }}</h4>
                                <p class="product-price"> Rp. {{ number_format($row->price) }}</p>
                                <a href="{{ url('/product/' . $row->slug) }}" class="cart-btn"><i
                                        class="fas fa-shopping-cart"></i>Details</a>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-md-12">
                        <h3 class="text-center">There is no product</h3>
                    </div>
                @endforelse


            </div>

            <div class="pagination justify-content-center  mt-4">
                {!! $products->links() !!}
            </div>

            <!-- <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="pagination-wrap">
                            <ul>
                                <li>{!! $products->links() !!}</li>
                            </ul> -->
            {{-- @if ($products->onFirstPage())
                        <ul>
                            <li><a href="#" class="active">
                                1
                            </a>
                            </li>
                            
                        </ul>
                        @else
                        <ul>
                            <li><a href="{{ $products->previousPageUrl() }}" class="">
                            {{ $products->currentPage() - 1 }}</a>
                            </li>
                            <li><a href="#"
                            class=" {{ $products->currentPage() == 1 ? 'active' : '' }}">
                            {{ $products->currentPage() }}
                            
                        </a>
                        </li>
                        </ul>
                        @endif

            @if ($products->hasMorePages())
            <ul>
                <li>
                    <a href="{{ $products->nextPageUrl() }}"
                        class="{{ $products->currentPage() > 1 ? 'active' : '' }}">
                        {{ $products->currentPage() + 1 }}
                    </a>
                </li>
            </ul>
            @endif --}}
            <!-- </div>
                    </div>
                </div> -->
        </div>
    </div>
    <!-- end products -->
@endsection
