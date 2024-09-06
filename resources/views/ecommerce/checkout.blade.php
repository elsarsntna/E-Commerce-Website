@extends('layouts.ecommerce')
@section('title')
    <title>Checkout -ElsaEcommerce</title>
@endsection
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>ecommerce</p>
                        <h1>Check Out Product</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- check out section -->
    <div class="checkout-section mt-150 mb-150 ">
        <div class="container">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('front.store_checkout') }}" method="post" novalidate="novalidate">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="checkout-accordion-wrap">
                            <div class="accordion" id="accordionExample">
                                <div class="card single-accordion">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Billing Address
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="billing-address ">

                                                <div>
                                                    <input type="text" autocomplete="off" id="first"
                                                        name="customer_name" placeholder="Name"
                                                        value="{{ $customer->name }}" required>
                                                    <p class="text-danger">{{ $errors->first('customer_name') }}</p>
                                                </div>
                                                <div>
                                                    <input type="text" autocomplete="off" id="number"
                                                        name="customer_phone" placeholder="Phone"
                                                        value="{{ $customer->phone_number }}" required>
                                                    <p class="text-danger">{{ $errors->first('customer_phone') }}</p>
                                                </div>
                                                <div>
                                                    <input type="email" autocomplete="off" id="email" name="email"
                                                        placeholder="Email" value="{{ $customer->email }}" readonly>
                                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                                </div>
                                                <div>
                                                    <input type="text" autocomplete="off" id="add1"
                                                        name="customer_address" placeholder="Address"
                                                        value="{{ $customer->address }}" required>
                                                    <p class="text-danger">{{ $errors->first('customer_address') }}</p>
                                                </div>
                                                <div>
                                                    <select name="province_id" id="province_id" required>
                                                        <option value="" disabled selected>Pilih Propinsi</option>
                                                        <!-- LOOPING DATA PROVINCE UNTUK DIPILIH OLEH CUSTOMER -->
                                                        @foreach ($provinces as $row)
                                                            <option value="{{ $row->id }}"
                                                                {{ $customer->district->province_id == $row->id ? 'selected' : '' }}>
                                                                {{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <p class="text-danger">{{ $errors->first('province_id') }}</p>
                                                </div>
                                                <div>
                                                    <select name="city_id" id="city_id" required>
                                                        <option value="" disabled selected>Pilih Kabupaten/Kota
                                                        </option>
                                                    </select>
                                                    <p class="text-danger">{{ $errors->first('city_id') }}</p>
                                                </div>
                                                <div>
                                                    <select name="district_id" id="district_id" required>
                                                        <option value="" disabled selected>Pilih Kecamatan</option>
                                                    </select>
                                                    <p class="text-danger">{{ $errors->first('district_id') }}</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    <div class="col-lg-4">
                        <div class="order-details-wrap">
                            <table class="order-details w-100">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="order-details-body">
                                    @foreach ($carts as $cart)
                                        <tr>
                                            <td>{{ \Str::limit($cart['product_name'], 10) }}</td>
                                            <td>Rp {{ number_format($cart['product_price']) }} </td>
                                            <td> {{ $cart->qty }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody class="checkout-details">

                                    <tr>
                                        <td>Total</td>
                                        <td colspan="2">Rp {{ number_format($subtotal) }}</td>

                                    </tr>
                                </tbody>
                            </table>

                            <button class="btn_oren mt-4">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- end check out section -->

    <!-- logo carousel -->
    <div class="logo-carousel-section">
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

@section('js')
    <script>
        //JADI KETIKA HALAMAN DI-LOAD
        $(document).ready(function() {
            //MAKA KITA MEMANGGIL FUNGSI LOADCITY() DAN LOADDISTRICT()
            //AGAR SECARA OTOMATIS MENGISI SELECT BOX YANG TERSEDIA
            loadCity($('#province_id').val(), 'bySelect').then(() => {
                loadDistrict($('#city_id').val(), 'bySelect');
            })
        })

        $('#province_id').on('change', function() {
            loadCity($(this).val(), '');
        })

        $('#city_id').on('change', function() {
            loadDistrict($(this).val(), '')
        })

        function loadCity(province_id, type) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{ url('/api/city') }}",
                    type: "GET",
                    data: {
                        province_id: province_id
                    },
                    success: function(html) {
                        $('#city_id').empty()
                        $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                        $.each(html.data, function(key, item) {

                            // KITA TAMPUNG VALUE CITY_ID SAAT INI
                            let city_selected = {{ $customer->district->city_id }};
                            //KEMUDIAN DICEK, JIKA CITY_SELECTED SAMA DENGAN ID CITY YANG DOLOOPING MAKA 'SELECTED' AKAN DIAPPEND KE TAG OPTION
                            let selected = type == 'bySelect' && city_selected == item.id ?
                                'selected' : '';
                            //KEMUDIAN KITA MASUKKAN VALUE SELECTED DI ATAS KE DALAM TAG OPTION
                            $('#city_id').append('<option value="' + item.id + '" ' + selected +
                                '>' + item.name + '</option>')
                            resolve()
                        })
                    }
                });
            })
        }

        //CARA KERJANYA SAMA SAJA DENGAN FUNGSI DI ATAS
        function loadDistrict(city_id, type) {
            $.ajax({
                url: "{{ url('/api/district') }}",
                type: "GET",
                data: {
                    city_id: city_id
                },
                success: function(html) {
                    $('#district_id').empty()
                    $('#district_id').append('<option value="">Pilih Kecamatan</option>')
                    $.each(html.data, function(key, item) {
                        let district_selected = {{ $customer->district->id }};
                        let selected = type == 'bySelect' && district_selected == item.id ? 'selected' :
                            '';
                        $('#district_id').append('<option value="' + item.id + '" ' + selected + '>' +
                            item.name + '</option>')
                    })
                }
            });
        }
    </script>
@endsection
