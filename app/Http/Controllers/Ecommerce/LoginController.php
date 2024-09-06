<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\CustomerRegisterMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Order;
use App\Customer;
use App\ShoppingCart;

class LoginController extends Controller
{

    public function loginForm()
    {
        if (auth()->guard('customer')->check())
            return redirect(route('customer.dashboard'));
        return view('ecommerce.login');
    }

    public function registerForm()
    {

        return view('ecommerce.register');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|string'
        ]);

        //CUKUP MENGAMBIL EMAIL DAN PASSWORD SAJA DARI REQUEST
        //KARENA JUGA DISERTAKAN TOKEN
        $auth = $request->only('email', 'password');
        $auth['status'] = 1; //TAMBAHKAN JUGA STATUS YANG BISA LOGIN HARUS 1

        //CHECK UNTUK PROSES OTENTIKASI
        //DARI GUARD CUSTOMER, KITA ATTEMPT PROSESNYA DARI DATA $AUTH
        if (auth()->guard('customer')->attempt($auth)) {
            //JIKA BERHASIL MAKA AKAN DIREDIRECT KE DASHBOARD
            $user_id = auth()->guard('customer')->user();
            $totalItems = ShoppingCart::where('customer_id', $user_id->id)->count();
            session()->put('cart_total', $totalItems);

            return redirect()->intended(route('customer.dashboard'));
        }
        //JIKA GAGAL MAKA REDIRECT KEMBALI BERSERTA NOTIFIKASI
        return redirect()->back()->with(['error' => 'Incorrect Email/Password']);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'phone_number' => 'required',
            'address' => 'required|string'
        ]);

        $verify = Customer::where('email', $request->all()['email'])->exists();

        if ($verify) {
            return back()->with('error', 'This email exist');
        } else {
            $password = Str::random(8);
            $bcryptPassword = bcrypt($password);
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $bcryptPassword,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'activate_token' => Str::random(30),
                'status' => false
            ]);

            Mail::to($request->email)->send(new CustomerRegisterMail($customer, $password));
            return redirect()->back()->with(['success' => "Please check your email for verification"]);
        }
    }

    public function dashboard()
    {
        $orders = Order::selectRaw('COALESCE(sum(CASE WHEN status = 0 THEN subtotal END), 0) as pending, 
        COALESCE(count(CASE WHEN status = 1 THEN subtotal END), 0) as waiting,
        COALESCE(count(CASE WHEN status = 2 THEN subtotal END), 0) as paking,
        COALESCE(count(CASE WHEN status = 3 THEN subtotal END), 0) as shipping,
        COALESCE(count(CASE WHEN status = 4 THEN subtotal END), 0) as completeOrder')
            ->where('customer_id', auth()->guard('customer')->user()->id)->get();

        return view('ecommerce.dashboard', compact('orders'));
    }

    public function logout()
    {
        auth()->guard('customer')->logout();
        return redirect(route('front.index'));

    }


}
