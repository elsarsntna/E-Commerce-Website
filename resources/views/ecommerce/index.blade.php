@extends('layouts.ecommerce')
@section('title')
    <title>ElsaEcommerce</title>
@endsection
@section('content')
    <!-- hero area -->
    <div class="hero-area hero-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 offset-lg-2 text-center">
                    <div class="hero-text">
                        <div class="hero-text-tablecell">
                            <p class="subtitle">Trendy & Stylish</p>
                            <h1>Explore the Latest Fashion Trends</h1>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end hero area -->


    <div class="list-section pt-80 pb-80">
        <div class="container">

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="list-box d-flex align-items-center">
                        <div class="list-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="content">
                            <h3>Free Shipping</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="list-box d-flex align-items-center">
                        <div class="list-icon">
                            <i class="fas fa-phone-volume"></i>
                        </div>
                        <div class="content">
                            <h3>24/7 Support</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="list-box d-flex justify-content-start align-items-center">
                        <div class="list-icon">
                            <i class="fas fa-sync"></i>
                        </div>
                        <div class="content">
                            <h3>Refund</h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- product section -->
    <div class="product-section mt-150 mb-150">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Our</span> Products</h3>

                    </div>
                </div>
            </div>

            <div class="row">
                @forelse($products as $row)
                    @if ($row->status == 1 && $row->stock > 0)
                        <div class="col-lg-4 col-md-6 text-center">
                            <div class="single-product-item">
                                <div class="product-image">
                                    <a href="{{ url('/product/' . $row->slug) }}">
                                        <img src="{{ $row->image != '' ? asset('storage/products/' . $row->image) : asset('assets/img/icons/brands/image-not-found.jpg') }}"
                                            alt="{{ $row->name }}">
                                    </a>
                                </div>
                                <h4>{{ $row->name }}</h4>
                                <p class="product-price"> Rp {{ number_format($row->price) }}</p>
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


        </div>
    </div>
    <!-- end product section -->

    <!-- cart banner section -->
    <section class="cart-banner pt-100 pb-100">
        <div class="container">
            @forelse($products as $row)
                @if ($row->status == 1 && $row->stock > 0)
                    @if ($loop->first)
                        <div class="row clearfix">
                            <!--Image Column-->
                            <div class="image-column col-lg-6">
                                <div class="image shadow">
                                    <!-- <div class="price-box">
                                                <div class="inner-price">
                                                    <span class="price">
                                                        <strong>30%</strong> <br> off per pcs
                                                    </span>
                                                </div>
                                            </div> -->
                                    <img src="{{ $row->image != '' ? asset('storage/products/' . $row->image) : asset('assets/img/icons/brands/image-not-found.jpg') }}"
                                        alt="{{ $row->name }}" style="border-radius: 15px;">
                                </div>
                            </div>
                            <!--Content Column-->
                            <div class="content-column col-lg-6">
                                <h3><span class="orange-text"> {{ $row->name }}</span></h3>
                                <h4 class="pt-4">
                                    <p><strong>Categories: </strong>{{ $row->category->name }}</p>
                                </h4>
                                <div class="text">
                                    {{ implode(' ', array_slice(explode('.', strip_tags($row->description)), 0, 2)) }}
                                </div>
                                <!--Countdown Timer-->
                                <div class="time-counter">
                                    {{--  <div class="time-countdown clearfix" >
                                        <div class="counter-column"> --}}
                                    <div class="inner">
                                        <h4><span class="orange-text"> Rp {{ number_format($row->price) }}</span></h4>
                                    </div>
                                    {{--   </div> 
                                    </div> --}}
                                </div>
                                <a href="{{ url('/product/' . $row->slug) }}" class="cart-btn mt-3"><i
                                        class="fas fa-shopping-cart"></i> Details </a>
                            </div>
                        </div>
                    @endif
                @endif
            @empty
                <div class="col-md-12">
                    <h3 class="text-center">Tidak ada produk</h3>
                </div>
            @endforelse

        </div>

    </section>
    <!-- end cart banner section -->


    <!-- shop banner -->
    <!-- <section class="shop-banner">
                <div class="container">
                    <h3>December sale is on! <br> with big <span class="orange-text">Discount...</span></h3>
                    <div class="sale-percent"><span>Sale! <br> Upto</span>50% <span>off</span></div>
                    <a href="shop.html" class="cart-btn btn-lg">Shop Now</a>
                </div>
            </section> -->
    <!-- end shop banner -->



    <!-- logo carousel -->
    <div class="logo-carousel-section ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-carousel-inner">
                        <div class="single-logo-item">
                            <img src="{{ asset('ecommerce2/img/company-logos/1.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('ecommerce2/img/company-logos/2.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('ecommerce2/img/company-logos/3.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('ecommerce2/img/company-logos/4.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('ecommerce2/img/company-logos/5.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end logo carousel -->
@endsection
