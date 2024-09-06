<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Province;
use App\City;
use App\District;
use App\Customer;
use App\ShoppingCart;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use DB;
use App\Mail\CustomerRegisterMail;
use Mail;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer'
        ]);

        // Periksa apakah pengguna sudah login
        $user = auth()->guard('customer')->user();
        if (!$user) {
            return redirect()->route('customer.login')->with(['error' => 'You must be logged in to add products to cart']);
        }

        // Cek ketersediaan stok produk
        $product = Product::find($request->product_id);
        if ($product->stock < $request->qty) {
            return redirect()->back()->with(['error' => 'Stock Product ' . $product->name . ' not sufficient']);
        }

        // Simpan data keranjang belanja ke dalam basis data
        ShoppingCart::updateOrCreate(
            ['customer_id' => $user->id, 'product_id' => $request->product_id],
            [
                'qty' =>
                    DB::raw("IFNULL(qty, 0) + {$request->qty}"),
                'product_image' => $product->image,
                'product_price' => $product->price,
                'product_name' => $product->name
            ]
        );

        // Set notifikasi jumlah keranjang belanja
        $totalItems = ShoppingCart::where('customer_id', $user->id)->count();
        session()->put('cart_total', $totalItems);
        return redirect()->back()->with('success', 'Product successfully added to the cart.');

    }

    public function listCart()
    {
        $user = auth()->guard('customer')->user();

        if (!$user) {
            $carts = [];
        } else {
            $carts = ShoppingCart::where('customer_id', $user->id)->get();
        }


        // Menghitung subtotal hanya untuk elemen array yang memiliki kunci product_price
        $subtotal = collect($carts)->filter(function ($item) {
            return isset ($item['product_price']);
        })->sum(function ($item) {
            return $item['qty'] * $item['product_price'];
        });


        //LOAD VIEW CART.BLADE.PHP DAN PASSING DATA CARTS DAN SUBTOTAL
        return view('ecommerce.cart', compact('carts', 'subtotal'));
    }

    public function updateCart(Request $request)
    {
        $user = auth()->guard('customer')->user();
        if (!$user) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('customer.login')->with('error', ' You need to login to proceed to the checkout process
            .');
        }

        foreach ($request->product_id as $key => $product_id) {
            // Ambil qty baru dari form
            $qty = $request->qty[$key];

            // Periksa apakah qty yang diterima adalah angka yang valid
            if (!is_numeric($qty) || $qty < 0) {
                // Jika qty tidak valid, kembalikan pesan kesalahan
                return redirect()->back()->with('error', 'Invalid qty entered.');
            }

            // Temukan entri keranjang belanja yang sesuai dalam basis data
            $shoppingCart = ShoppingCart::where('customer_id', $user->id)->where('product_id', $product_id)->first();
            if ($shoppingCart) {
                // Perbarui qty produk dalam keranjang belanja
                if ($qty == 0) {
                    // Jika qty = 0, hapus produk dari keranjang belanja
                    $shoppingCart->delete();
                } else {
                    // Jika qty > 0, update qty produk dalam keranjang belanja
                    $shoppingCart->qty = $qty;
                    $shoppingCart->save();
                }
            }
        }

        // Set notifikasi jumlah keranjang belanja
        $totalItems = ShoppingCart::where('customer_id', $user->id)->count();
        session()->put('cart_total', $totalItems);
        return redirect()->back();
    }

    private function getCarts()
    {
        $carts = json_decode(request()->cookie('dw-carts'), true);
        $carts = $carts != '' ? $carts : [];
        return $carts;
    }

    public function checkout()
    {


        $user = auth()->guard('customer')->user();
        $customer = auth()->guard('customer')->user()->load('district');
        $provinces = Province::orderBy('name', 'ASC')->get();

        if (!$user) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('customer.login')->with('error', 'You need to login to proceed to the checkout process.');
        }

        // Ambil keranjang belanja pengguna
        $carts = ShoppingCart::where('customer_id', $user->id)->get();

        // Periksa apakah ada produk yang stoknya melebihi batas
        foreach ($carts as $cart) {
            $product = Product::find($cart->product_id);
            if ($product->stock < $cart->qty) {
                // Jika stok melebihi batas, kirim notifikasi dan kembalikan ke halaman sebelumnya
                return redirect()->back()->with('error', 'Sorry, the stock for ' . $product->name . ' is insufficient.');
            }
        }

        //QUERY UNTUK MENGAMBIL SEMUA DATA PROPINSI
        $provinces = Province::orderBy('created_at', 'DESC')->get();

        // Menghitung subtotal hanya untuk elemen array yang memiliki kunci product_price
        $subtotal = collect($carts)->filter(function ($item) {
            return isset ($item['product_price']);
        })->sum(function ($item) {
            return $item['qty'] * $item['product_price'];
        });

        //ME-LOAD VIEW CHECKOUT.BLADE.PHP DAN PASSING DATA PROVINCES, CARTS DAN SUBTOTAL
        return view('ecommerce.checkout', compact('provinces', 'carts', 'subtotal', 'customer'));
    }



    public function getCity()
    {
        //QUERY UNTUK MENGAMBIL DATA KOTA / KABUPATEN BERDASARKAN PROVINCE_ID
        $cities = City::where('province_id', request()->province_id)->get();
        //KEMBALIKAN DATANYA DALAM BENTUK JSON
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function getDistrict()
    {
        //QUERY UNTUK MENGAMBIL DATA KECAMATAN BERDASARKAN CITY_ID
        $districts = District::where('city_id', request()->city_id)->get();
        //KEMUDIAN KEMBALIKAN DATANYA DALAM BENTUK JSON
        return response()->json(['status' => 'success', 'data' => $districts]);
    }

    public function processCheckout(Request $request)
    {

        //VALIDASI DATANYA
        $this->validate($request, [
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required',
            'email' => 'required|email',
            'customer_address' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'required|exists:districts,id'
        ]);

        //INISIASI DATABASE TRANSACTION
        //DATABASE TRANSACTION BERFUNGSI UNTUK MEMASTIKAN SEMUA PROSES SUKSES UNTUK KEMUDIAN DI COMMIT AGAR DATA BENAR BENAR DISIMPAN, JIKA TERJADI ERROR MAKA KITA ROLLBACK AGAR DATANYA SELARAS
        DB::beginTransaction();
        try {
            //CHECK DATA CUSTOMER BERDASARKAN EMAIL
            $customer = Customer::where('email', $request->email)->first();

            //LAKUKAN PERUBAHAN PADA BAGIAN INI
            if (!auth()->guard('customer')->check() && $customer) {
                return redirect()->back()->with(['error' => 'Please Login First']);
            }

            //AMBIL DATA KERANJANG
            $carts = ShoppingCart::where('customer_id', $customer->id)->get();
            //HITUNG SUBTOTAL BELANJAAN
            $subtotal = collect($carts)->sum(function ($q) {
                return $q['qty'] * $q['product_price'];
            });

            //UNTUK MENGHINDARI DUPLICATE CUSTOMER, MASUKKAN QUERY UNTUK MENAMBAHKAN CUSTOMER BARU
            //SEBENARNYA VALIDASINYA BISA DIMASUKKAN PADA METHOD VALIDATION DIATAS, TAPI TIDAK MENGAPA UNTUK MENCOBA CARA BERBEDA
            if (!auth()->guard('customer')->check()) {
                $password = Str::random(8);
                $customer = Customer::create([
                    'name' => $request->customer_name,
                    'email' => $request->email,
                    'password' => $password,
                    'phone_number' => $request->customer_phone,
                    'address' => $request->customer_address,
                    'district_id' => $request->district_id,
                    'activate_token' => Str::random(30),
                    'status' => false
                ]);
            }


            //SIMPAN DATA ORDER
            $order = Order::create([
                'invoice' => Str::random(4) . '-' . time(), //INVOICENYA KITA BUAT DARI STRING RANDOM DAN WAKTU
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'district_id' => $request->district_id,
                'subtotal' => $subtotal
            ]);

            //LOOPING DATA DI CARTS
            foreach ($carts as $row) {
                //AMBIL DATA PRODUK BERDASARKAN PRODUCT_ID
                $product = Product::find($row['product_id']);

                // Periksa ketersediaan stok produk
                if ($product->stock < $row['qty']) {
                    return redirect()->back()->with(['error' => 'Stock product ' . $product->name . ' not sufficient']);
                }

                // Kurangi stok produk
                $product->stock -= $row['qty'];
                $product->setDraftIfOutOfStock();
                $product->save();

                //SIMPAN DETAIL ORDER
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $row['product_id'],
                    'price' => $row['product_price'],
                    'qty' => $row['qty'],
                    'weight' => $product->weight
                ]);
            }

            //TIDAK TERJADI ERROR, MAKA COMMIT DATANYA UNTUK MENINFORMASIKAN BAHWA DATA SUDAH FIX UNTUK DISIMPAN
            $user = auth()->guard('customer')->user();
            if ($user) {
                ShoppingCart::where('customer_id', $user->id)->delete();
            }

            $totalItems = ShoppingCart::where('customer_id', $user->id)->count();
            session()->put('cart_total', $totalItems);

            DB::commit();
            if (!auth()->guard('customer')->check()) {
                Mail::to($request->email)->send(new CustomerRegisterMail($customer, $password));
            }
            return redirect(route('front.finish_checkout', $order->invoice));
        } catch (\Exception $e) {
            //JIKA TERJADI ERROR, MAKA ROLLBACK DATANYA
            DB::rollback();
            //DAN KEMBALI KE FORM TRANSAKSI SERTA MENAMPILKAN ERROR
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function checkoutFinish($invoice)
    {
        //AMBIL DATA PESANAN BERDASARKAN INVOICE
        $order = Order::with(['district.city'])->where('invoice', $invoice)->first();
        //LOAD VIEW checkout_finish.blade.php DAN PASSING DATA ORDER
        return view('ecommerce.checkout_finish', compact('order'));
    }

    public function removeCart(Request $request)
    {
        // dd($request);
        // Validasi request
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        try {
            // Cari item keranjang belanja berdasarkan ID produk dan hapus
            $product_id = $request->product_id;
            $user_id = auth()->guard('customer')->user();
            //dd($user_id);
            ShoppingCart::where('customer_id', $user_id->id)
                ->where('product_id', $product_id)
                ->delete();
            $totalItems = ShoppingCart::where('customer_id', $user_id->id)->count();
            session()->put('cart_total', $totalItems);
            return redirect()->back()->with('success', 'Item successfully removed from shopping cart');
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return redirect()->back()->with('error', 'An error occurred while deleting an item from the shopping cart:' . $e->getMessage());
        }
    }

    public function removeAll(Request $request)
    {
        try {
            // Dapatkan ID pengguna yang sedang login
            $userId = auth()->guard('customer')->user();

            // Hapus semua item keranjang belanja yang terkait dengan pengguna tersebut
            ShoppingCart::where('customer_id', $userId->id)->delete();
            $totalItems = ShoppingCart::where('customer_id', $userId->id)->count();
            session()->put('cart_total', $totalItems);
            // Redirect kembali ke halaman keranjang belanja dengan pesan sukses
            return redirect()->back()->with('success', 'All items from the shopping cart were successfully deleted');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, redirect kembali ke halaman keranjang belanja dengan pesan kesalahan
            return redirect()->back()->with('error', 'An error occurred while deleting an item from the shopping cart: ' . $e->getMessage());
        }
    }
}