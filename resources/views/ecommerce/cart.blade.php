@extends('layouts.ecommerce')
@section('title')
    <title>Cart - ElsaEcommerce</title>
@endsection
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>ecommerce</p>
                        <h1>Cart</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->



    <!-- cart -->
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            @if (session('message'))
                <div class="alert alert-danger text-center" style="border-radius: 15px;">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-danger text-center" style="border-radius: 15px;">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger text-center" style="border-radius: 15px;">
                    {{ session('error') }}
                </div>
            @endif


            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <form action="{{ route('front.update_cart') }}" method="post">
                                @csrf
                                <thead class="cart-table-head">
                                    <tr class="table-head-row">
                                        <th class="product-image">Product Image</th>
                                        <th class="product-name">Name</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-total">Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($carts as $row)
                                        <tr class="table-body-row">
                                            <td class="product-image">
                                                <img src="{{ asset('storage/products/' . $row['product_image']) }}"
                                                    alt="{{ $row['product_name'] }} " style="border-radius: 10px;">


                                            </td>
                                            <td class="product-name">{{ $row['product_name'] }}</td>
                                            <td class="product-price">Rp {{ number_format($row['product_price']) }}</td>
                                            <td class="product-quantity"><input type="number" name="qty[]" min="1"
                                                    value="{{ $row['qty'] }}" title="Quantity:" class="input-text qty">
                                                <input type="hidden" name="product_id[]" value="{{ $row['product_id'] }}"
                                                    class="form-control"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </td>
                                            <td class="product-total">Rp
                                                {{ number_format($row['product_price'] * $row['qty']) }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn hapus-item" id="hapus-item"
                                                    data-product-id="{{ $row['product_id'] }}"><i class="fas fa-trash"
                                                        style="color: red;"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Your cart is empty</td>
                                        </tr>
                                    @endforelse
                                    @if (count($carts) > 0)
                                        <tr class="table-body-row">
                                            <td colspan="3">
                                                <button type="button" id="hapus-semua-btn" class="btn_oren">
                                                    Delete All
                                                </button>
                                            </td>
                                            <td colspan="3">
                                                <button class="btn_oren">Update Cart</button>

                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </form>
                        </table>
                    </div>
                </div>



                <div class="col-lg-4">
                    <div class="total-section">
                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row text-center">
                                    <th colspan="2">Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="total-data">
                                    <td><strong>Total : </strong></td>
                                    <td>Rp {{ number_format($subtotal) }}</td>
                                </tr>

                            </tbody>
                        </table>
                        @if ($carts->isEmpty())
                            <div class="cart-buttons text-center">
                                <a href="{{ route('front.product') }}" class="boxed-btn">Continue Shopping</a>
                            </div>
                        @else
                            <div class="cart-buttons text-center">
                                <a href="{{ route('front.product') }}" class="boxed-btn">Continue Shopping</a>
                                <a href="{{ route('front.checkout') }}" class="boxed-btn black">Check Out</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end cart -->
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hapusBtns = document.querySelectorAll('.hapus-item');
        hapusBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const form = document.createElement('form');
                form.method = 'post';
                form.action = '{{ route('front.remove_cart') }}';
                form.innerHTML = `
                    @csrf
                    <input type="hidden" name="product_id" value="${productId}">
                `;
                document.body.appendChild(form);
                form.submit();
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hapusSemuaBtn = document.getElementById('hapus-semua-btn');

        hapusSemuaBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove all items from the shopping cart?')) {
                // Buat sebuah form dinamis
                const form = document.createElement('form');
                form.method = 'post';
                form.action = '{{ route('front.remove_all_cart') }}';
                // Tambahkan token CSRF
                const csrfTokenInput = document.createElement('input');
                csrfTokenInput.type = 'hidden';
                csrfTokenInput.name = '_token';
                csrfTokenInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfTokenInput);
                // Submit form
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
