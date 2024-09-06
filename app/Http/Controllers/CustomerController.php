<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Province;

class CustomerController extends Controller
{
    public function index()
    {
        $dataCustomer = Customer::orderBy('created_at', 'DESC')->paginate(10);
        return view('customer.index', compact('dataCustomer'));
    }

    public function edit($id)
    {
        $dataEditCustomer = Customer::findOrFail($id);
        $provinces = Province::orderBy('name', 'ASC')->get();
        return view('customer.edit', compact('dataEditCustomer', 'provinces'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'phone_number' => 'required|max:15',
            'address' => 'required|string',
            'district_id' => 'required|exists:districts,id',
            'password' => 'nullable|string|min:6',
            'status' => 'nullable'
        ]);

        $updateCustomer = Customer::find($id);
        $newPassword = bcrypt($request->password);
        $password = $request->password == null ? $updateCustomer->password : $newPassword;

        $updateCustomer->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'district_id' => $request->district_id,
            'password' => $password,
            'status' => $request->status
        ]);

        return redirect(route('customer.index'))->with(['success' => 'Customer successfully updated']);
    }
}