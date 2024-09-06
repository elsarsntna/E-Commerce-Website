<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Product;
use App\Category;
use App\ShoppingCart;
use File;




class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['category'])->orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $product = $product->where('name', 'LIKE', '%' . request()->q . '%');
        }
        $product = $product->paginate(5);
        return view('products.index', compact('product'));
    }

    public function create()
    {
        $category = Category::orderBy('name', 'DESC')->get();
        return view('products.create', compact('category'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products|string|max:100',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'weight' => 'required|integer',
            'image' => 'required|image|mimes:png,jpeg,jpg'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/products', $filename);

            $product = Product::create([
                'name' => $request->name,
                'slug' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image' => $filename,
                'stock' => $request->stock,
                'price' => $request->price,
                'weight' => $request->weight,
                'status' => $request->status
            ]);
            return redirect(route('product.index'))->with(['success' => ' Products added successfully']);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::orderBy('name', 'DESC')->get();
        return view('products.edit', compact('product', 'category'));
    }

    public function update(Request $request, $id)
    {
        //VALIDASI DATA YANG DIKIRIM
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'weight' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:png,jpeg,jpg' //IMAGE BISA NULLABLE
        ]);

        $product = Product::find($id); //AMBIL DATA PRODUK YANG AKAN DIEDIT BERDASARKAN ID
        $filename = $product->image; //SIMPAN SEMENTARA NAMA FILE IMAGE SAAT INI


        //JIKA ADA FILE GAMBAR YANG DIKIRIM
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            //MAKA UPLOAD FILE TERSEBUT
            $file->storeAs('public/products', $filename);
            //DAN HAPUS FILE GAMBAR YANG LAMA
            File::delete(storage_path('app/public/products/' . $product->image));
        }

        //KEMUDIAN UPDATE PRODUK TERSEBUT
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'image' => $filename,
            'status' => $request->status
        ]);



        $shoppingCarts = ShoppingCart::where('product_id', $product->id)->get();
        foreach ($shoppingCarts as $cart) {
            $cart->update([
                'product_price' => $product->price
            ]);
        }
        return redirect(route('product.index'))->with(['warning' => 'Product Data successfully updated']);
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        File::delete(storage_path('app/public/products/' . $product->image));
        $product->delete();
        return redirect(route('product.index'))->with(['error' => 'Product successfully deleted']);
    }




}
