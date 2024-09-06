<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cart', function () {
    // Hapus cookie dengan membuat cookie baru yang kedaluwarsa
    $cookie = Cookie::forget('dw-carts');
    $cart_total = Cookie::forget('cart_total');

    // Redirect kembali dengan pesan sukses dan mengatur cookie
    return redirect()->back()->with('success', 'Cart cleared successfully.')->cookie($cookie)->cookie($cart_total);
})->name('cart');

Route::fallback(function () {
    return view('errors.404');
});

Route::group(['middleware' => 'prevent-back-history'], function () {

    Route::get('/', 'Ecommerce\FrontController@index')->name('front.index');
    Route::get('/product', 'Ecommerce\FrontController@product')->name('front.product');
    Route::get('/category/{slug}', 'Ecommerce\FrontController@categoryProduct')->name('front.category');
    Route::get('/product/{slug}', 'Ecommerce\FrontController@show')->name('front.show_product');

    Route::post('cart', 'Ecommerce\CartController@addToCart')->name('front.cart');



    Route::group(['prefix' => 'member', 'namespace' => 'Ecommerce', 'middleware' => 'prevent-back-history'], function() {
        Route::get('login', 'LoginController@loginForm')->name('customer.login');
        Route::get('register', 'LoginController@registerForm')->name('customer.register');

        Route::post('login', 'LoginController@login')->name('customer.post_login');
        Route::post('register', 'LoginController@register')->name('customer.post_register');

        Route::get('verify/{token}', 'FrontController@verifyCustomerRegistration')->name('customer.verify');

        Route::group(['middleware' => ['customer','prevent-back-history']], function() {
            Route::get('dashboard', 'LoginController@dashboard')->name('customer.dashboard');
            Route::get('logout', 'LoginController@logout')->name('customer.logout');

            Route::get('orders', 'OrderController@index')->name('customer.orders');
            Route::get('orders/{invoice}', 'OrderController@view')->name('customer.view_order');
            Route::get('orders/pdf/{invoice}', 'OrderController@pdf')->name('customer.order_pdf');
            Route::post('orders/accept', 'OrderController@acceptOrder')->name('customer.order_accept');
            Route::get('orders/return/{invoice}', 'OrderController@returnForm')->name('customer.order_return');
            Route::put('orders/return/{invoice}', 'OrderController@processReturn')->name('customer.return');

            Route::get('payment', 'OrderController@paymentForm')->name('customer.paymentForm');
            Route::post('payment', 'OrderController@storePayment')->name('customer.savePayment');

            Route::get('setting', 'FrontController@customerSettingForm')->name('customer.settingForm');
            Route::post('setting', 'FrontController@customerUpdateProfile')->name('customer.setting');

            Route::get('/cart', 'CartController@listCart')->name('front.list_cart');
            Route::post('/cart/update', 'CartController@updateCart')->name('front.update_cart');

            Route::get('/checkout', 'CartController@checkout')->name('front.checkout');
            Route::post('/checkout', 'CartController@processCheckout')->name('front.store_checkout');
            Route::get('/checkout/{invoice}', 'CartController@checkoutFinish')->name('front.finish_checkout');
            Route::post('/cart/remove', 'CartController@removeCart')->name('front.remove_cart');
            Route::post('/cart/remove-all', 'CartController@removeAll')->name('front.remove_all_cart');

            Route::get('/dashboard/unpaid-orders', 'OrderController@unpaidOrders')->name('unpaid.orders');
            Route::get('/dashboard/confirm-orders', 'OrderController@confirmOrders')->name('confirm.orders');
            Route::get('/dashboard/paking-orders', 'OrderController@pakingOrders')->name('paking.orders');
            Route::get('/dashboard/shipping-orders', 'OrderController@shippingOrders')->name('shipping.orders');
            Route::get('/dashboard/finish-orders', 'OrderController@finishOrders')->name('finish.orders');


            
        });
    });

    Auth::routes();

    Route::group(['prefix' => 'administrator', 'middleware' => ['auth','prevent-back-history']], function() {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::post('/logoutadmin', 'HomeController@logoutadmin')->name('admin.logout');
        

        Route::resource('category', 'CategoryController')->except(['create', 'show']);
        Route::resource('product', 'ProductController')->except(['show']);
       

        Route::group(['prefix' => 'orders'], function() {
            Route::get('/', 'OrderController@index')->name('orders.index');
            Route::get('/{invoice}', 'OrderController@view')->name('orders.view');
            Route::get('/payment/{invoice}', 'OrderController@acceptPayment')->name('orders.approve_payment');
            Route::post('/shipping', 'OrderController@shippingOrder')->name('orders.shipping');
            Route::delete('/{id}', 'OrderController@destroy')->name('orders.destroy');
            Route::get('/return/{invoice}', 'OrderController@return')->name('orders.return');
            Route::post('/return', 'OrderController@approveReturn')->name('orders.approve_return');
        });

      
            Route::get('/ReportOrder', 'HomeController@orderReport')->name('report.order');
            Route::get('/ReportOrder/pdf/{daterange}', 'HomeController@orderReportPdf')->name('report.order_pdf');
            Route::get('/ReportReturn', 'HomeController@returnReport')->name('report.return');
            Route::get('/ReportReturn/pdf/{daterange}', 'HomeController@returnReportPdf')->name('report.return_pdf');
       

        Route::get('/customer', 'customerController@index')->name('customer.index');
        Route::get('/customer/create', 'customerController@create')->name('customer.create');
        Route::post('/customer', 'customerController@store')->name('customer.store');
        Route::get('/customer/{id}/edit', 'customerController@edit')->name('customer.edit');
        Route::put('/customer/{id}', 'customerController@update')->name('customer.update');
        Route::delete('/customer/{id}', 'customerController@destroy')->name('customer.destroy');
    });
});

