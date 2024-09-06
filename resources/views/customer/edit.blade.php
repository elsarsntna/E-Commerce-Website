@extends('layouts.admin')

@section('title')
    <title>Edit Customer</title>
@endsection

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Home</a></li>
        <li class="breadcrumb-item active">Edit Customer</li>
    </ol>
    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit customer</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert" id="notification">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert" id="notification">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('customer.update', $dataEditCustomer->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $dataEditCustomer->id }}" />

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" class="form-control" id="name" name="name"
                                    value="{{ $dataEditCustomer->name }}" required>
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" class="form-control" id="email" name="email"
                                    value="{{ $dataEditCustomer->email }}" required>
                                <p class="text-danger">{{ $errors->first('email') }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="password">Password</label>
                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" class="form-control" id="password" name="password"
                                    placeholder="******">
                                <p class="text-danger">{{ $errors->first('password') }}</p>
                                <p>Leave it blank if you don't want to change your password</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="phone_number">Phone Number</label>
                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" class="form-control" id="phone_number"
                                    name="phone_number" value="{{ $dataEditCustomer->phone_number }}" required>
                                <p class="text-danger">{{ $errors->first('phone_number') }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="address">Address</label>
                            <div class="col-sm-10">
                                <input type="text" autocomplete="off" class="form-control" id="address" name="address"
                                    value="{{ $dataEditCustomer->address }}" required>
                                <p class="text-danger">{{ $errors->first('address') }}</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="province_id">Province</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="province_id" id="province_id" required>
                                    <option value="" disabled selected>Pilih Propinsi</option>
                                    @foreach ($provinces as $row)
                                        <option value="{{ $row->id }}"
                                            {{ $dataEditCustomer->district->province_id == $row->id ? 'selected' : '' }}>
                                            {{ $row->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="city_id">City</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="city_id" id="city_id" required>
                                    <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="district_id">District</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="district_id" id="district_id" required>
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value="1" type="radio" name="status"
                                        id="status_active" {{ $dataEditCustomer->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_active">Active</label>
                                </div>
                                <div class="form-check form-check-inline ml-3">
                                    <input class="form-check-input" value="0" type="radio" name="status"
                                        id="status_not_active" {{ $dataEditCustomer->status == 0 ? 'checked ' : '' }}>
                                    <label class="form-check-label" for="status_not_active">Not Active</label>
                                </div>
                                <p class="text-danger">{{ $errors->first('status') }}</p>
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
                            let city_selected = {{ $dataEditCustomer->district->city_id }};
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
                        let district_selected = {{ $dataEditCustomer->district->id }};
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
