@extends('layouts.ecommerce')

@section('title')
    <title>CheckoutFinish - ElsaEcommerce</title>
@endsection

@section('content')
    <!--================Home Banner Area =================-->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>ecommerce</p>
                        <h1>Thank you order received </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Home Banner Area =================-->






    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Card details


                                        </button>




                                    </h5>


                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <table>
                                                        <tr>
                                                            <td><strong>Invoice</strong></td>
                                                            <td style="width: 30%;"></td>
                                                            <td>: {{ $order->invoice }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Date</strong></td>
                                                            <td style="width: 30%;"></td>
                                                            <td>: {{ $order->created_at }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Total</strong></td>
                                                            <td style="width: 30%;"></td>
                                                            <td>: Rp {{ number_format($order->subtotal) }}</td>
                                                        </tr>
                                                    </table>

                                                </div>
                                                <div class="col-lg-6">
                                                    <table>
                                                        <tr>
                                                            <td><strong>Address</strong></td>
                                                            <td style="width: 35%;"></td>
                                                            <td>: {{ $order->customer_address }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>City</strong></td>
                                                            <td style="width: 35%;"></td>
                                                            <td>: {{ $order->district->city->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Country</strong></td>
                                                            <td style="width: 35%;"></td>
                                                            <td>: Indonesia</td>
                                                        </tr>
                                                    </table>

                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <a href="{{ url('member/payment?invoice=' . $order->invoice) }}"
                                                        class="boxed-btn btn-sm float-left mt-3 mb-3">Payment</a>
                                                </div>
                                                <div class="col-lg-6">
                                                    <a href="{{ route('customer.order_pdf', $order->invoice) }}"
                                                        target="_blank" class="boxed-btn btn-sm float-left mt-3 mb-3">View
                                                        order</a>
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



    <!--================End Order Details Area =================-->
@endsection
