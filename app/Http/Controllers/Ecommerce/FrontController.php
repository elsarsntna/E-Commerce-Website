<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Province;
use App\Customer;

class FrontController extends Controller
{
    public function index()
    {

        $products = Product::orderBy('created_at', 'DESC')->paginate(12);
        return view('ecommerce.index', compact('products'));
    }

    public function product()
    {

        $products = Product::orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $product = $products->where('name', 'LIKE', '%' . request()->q . '%');
        }
        $products = $products->paginate(12);
        return view('ecommerce.product', compact('products'));
    }

    public function categoryProduct($slug)
    {
        $products = Category::where('slug', $slug)->first()->product()->orderBy('created_at', 'DESC')->paginate(12);
        return view('ecommerce.product', compact('products'));
    }

    public function show($slug)
    {
        //QUERY UNTUK MENGAMBIL SINGLE DATA BERDASARKAN SLUG-NYA
        $product = Product::with(['category'])->where('slug', $slug)->first();
        return view('ecommerce.show', compact('product'));
    }

    public function customerSettingForm()
    {

        $customer = auth()->guard('customer')->user()->load('district');
        $provinces = Province::orderBy('name', 'ASC')->get();
        return view('ecommerce.setting', compact('customer', 'provinces'));
    }

    public function customerUpdateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'phone_number' => 'required|max:15',
            'address' => 'required|string',
            'district_id' => 'required|exists:districts,id',
            'password' => 'nullable|string|min:6'
        ]);

        $user = auth()->guard('customer')->user();
        //AMBIL DATA YANG DIKIRIM DARI FORM
        //TAPI HANYA 4 COLUMN SAJA SESUAI YANG ADA DI BAWAH
        $data = $request->only('name', 'phone_number', 'address', 'district_id');
        //ADAPUN PASSWORD KITA CEK DULU, JIKA TIDAK KOSONG
        if ($request->password != '') {
            //MAKA TAMBAHKAN KE DALAM ARRAY
            $data['password'] = bcrypt($request->password);
        }
        //TERUS UPDATE DATANYA
        $user->update($data);
        //DAN REDIRECT KEMBALI DENGAN MENGIRIMKAN PESAN BERHASIL
        return redirect()->back()->with(['success' => 'Profile updated successfully']);
    }




    public function verifyCustomerRegistration($token)
    {
        // Menemukan data pelanggan berdasarkan token
        $customer = Customer::where('activate_token', $token)->first();

        if ($customer) {
            // Memeriksa apakah token kadaluwarsa 
            if ($customer->created_at->addMinutes(60)->isPast()) {
                // Hapus data pelanggan
                $customer->delete();
                return redirect(route('customer.login'))->with(['error' => 'Token expired, please register again.']);
            }

            // Memperbarui status pelanggan menjadi aktif
            $customer->update([
                'activate_token' => null,
                'status' => 1
            ]);

            // Redirect ke halaman login dengan pesan sukses
            return redirect(route('customer.login'))->with(['success' => 'Verification successful, please login..']);
        }

        // Jika tidak ada data pelanggan yang cocok dengan token
        return redirect(route('customer.login'))->with(['error' => 'Invalid verification token.']);
    }
}
