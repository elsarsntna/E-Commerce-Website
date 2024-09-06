@extends('layouts.ecommerce')

@section('title')
    <title>Konfirmasi Pembayaran - Elsa Ecommerce</title>
@endsection

@section('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
    <!--================Home Banner Area =================-->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Payment</p>
                        <h1>Confirm</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                <div class="card-header">
                                    <h4 class="card-title">Payment Confirmation</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('customer.savePayment') }}" enctype="multipart/form-data"
                                        method="post">
                                        @csrf

                                        @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger">{{ session('error') }}</div>
                                        @endif

                                        <div class="billing-address">

                                            <div>
                                                <label for="invoice">Invoice ID</label>
                                                <input type="text" name="invoice" id="invoice" autocomplete="off"
                                                    value="{{ request()->invoice }}" readonly>
                                                <p class="text-danger">{{ $errors->first('invoice') }}</p>
                                            </div>
                                            <div>
                                                <label for="name">Name</label>
                                                <input type="text" autocomplete="off" name="name" id="name"
                                                    placeholder="Name" value="{{ $orders->customer->name }}" required>
                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                            </div>
                                            <div>
                                                <label for="transfer_to">Transfer To</label>
                                                <select name="transfer_to" id="transfer_to" required>
                                                    <option value="" disabled selected>Select</option>
                                                    <option value="BCA - 1234567">BCA: 1234567 elsarsntna</option>
                                                    <option value="Mandiri - 2345678">Mandiri: 2345678 elsarsntna</option>
                                                    <option value="BRI - 9876543">BNI: 9876543 elsarsntna</option>
                                                    <option value="BNI - 6789456">BRI: 6789456 elsarsntna</option>
                                                </select>
                                                <p class="text-danger">{{ $errors->first('transfer_to') }}</p>
                                            </div>
                                            <div>
                                                <label for="amount">Transfer Amount</label>
                                                <input type="number" name="amount" id="amount"
                                                    placeholder="Transfer Amount" value="{{ $orders->subtotal }}" readonly>
                                                <p class="text-danger">{{ $errors->first('amount') }}</p>
                                            </div>
                                            <div>
                                                <label for="transfer_date">Transfer Date</label>
                                                <input type="date" name="transfer_date" id="transfer_date"
                                                    placeholder="Transfer Date" required>
                                                <p class="text-danger">{{ $errors->first('transfer_date') }}</p>
                                            </div>
                                            <div>
                                                <label for="proof">Transfer Proof</label>
                                                <input type="file" name="proof" id="proof" required>
                                                <p class="text-danger">{{ $errors->first('proof') }}</p>
                                            </div>
                                            <div>
                                                <button class="btn_oren btn-sm">Confirm</button>
                                            </div>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        $(document).ready(function() {
            $('#transfer_date').daterangepicker({
                singleDatePicker: true, // Set hanya satu tanggal
                showDropdowns: true, // Menunjukkan dropdown untuk bulan dan tahun
                autoUpdateInput: false,
                alwaysShowCalendars: false, // Menyembunyikan kalender
                linkedCalendars: false, // Menyinkronkan kalender (untuk rentang tanggal)
                autoApply: true, // Menerapkan otomatis setelah memilih tanggal
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD',
                },
            });

            // Menangani peristiwa saat memilih tanggal
            $('#transfer_date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
            });

            // Menangani peristiwa saat membersihkan tanggal
            $('#transfer_date').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection

{{-- @section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi tanggal dengan hari ini
            let today = moment().format('DD-MM-YYYY');

            // Set nilai pada elemen input
            document.getElementById('transfer_date').value = today;
        });
    </script>
@endsection --}}
