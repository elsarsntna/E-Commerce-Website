@extends('layouts.ecommerce')

@section('title')
    <title>Pengaturan - Elsa Ecommerce</title>
@endsection

@section('content')
    <!--================Home Banner Area =================-->
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Profile</p>
                        <h1>Setting</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!--================End Home Banner Area =================-->

    <div class="container">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="pt-80 pb-80">
                    @include('layouts.ecommerce.module.sidebar')
                </div>
            </div>

            <!-- Informasi Pesanan -->
            <div class="col-md-9">
                <div class="pt-80 pb-80">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card " style="border-radius: 15px;">
                                <div class="card-header" style="background-color: #F28123;">
                                    <h4 class="card-title text-white">Personal Information</h4>
                                </div>
                                <div class="card-body">
                                    @if (session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <form action="{{ route('customer.setting') }}" method="post">
                                        @csrf
                                        <div class="billing-address">

                                            <div>
                                                <label for="name">Full Name</label>
                                                <input type="text" autocomplete="off" id="name" name="name"
                                                    required value="{{ $customer->name }}">
                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                            </div>
                                            <div>
                                                <label for="email">Email</label>
                                                <input type="email" autocomplete="off" id="email" name="email"
                                                    required value="{{ $customer->email }}" readonly>
                                                <p class="text-danger">{{ $errors->first('email') }}</p>
                                            </div>
                                            <div>
                                                <label for="password">Password</label>
                                                <input type="password" autocomplete="off" name="password"
                                                    placeholder="******" id="password">
                                                <p class="text-danger">{{ $errors->first('password') }}</p>
                                                <p>Leave blank if you don't want to change the password</p>
                                            </div>
                                            <div>
                                                <label for="phone_number">Phone</label>
                                                <input autocomplete="off" type="text" id="phone_number"
                                                    name="phone_number" required value="{{ $customer->phone_number }}">
                                                <p class="text-danger">{{ $errors->first('phone_number') }}</p>
                                            </div>
                                            <div>
                                                <label for="address">Address</label>
                                                <input type="text" autocomplete="off" name="address" id="address"
                                                    required value="{{ $customer->address }}">
                                                <p class="text-danger">{{ $errors->first('address') }}</p>
                                            </div>
                                            <div>
                                                <label for="province_id">Province</label>
                                                <select name="province_id" id="province_id" required>
                                                    <option value="">Pilih Propinsi</option>
                                                    @foreach ($provinces as $row)
                                                        <option value="{{ $row->id }}"
                                                            {{ $customer->district->province_id == $row->id ? 'selected' : '' }}>
                                                            {{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ $errors->first('province_id') }}</p>
                                            </div>
                                            <div>
                                                <label for="city_id">City</label>
                                                <select name="city_id" id="city_id" required>
                                                    <option value="">Pilih Kabupaten/Kota</option>
                                                </select>
                                                <p class="text-danger">{{ $errors->first('city_id') }}</p>
                                            </div>
                                            <div>
                                                <label for="district_id">District</label>
                                                <select name="district_id" id="district_id" required>
                                                    <option value="">Pilih Kecamatan</option>
                                                </select>
                                                <p class="text-danger">{{ $errors->first('district_id') }}</p>
                                            </div>
                                            <button class="btn_oren btn-sm">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--================Login Box Area =================-->
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
