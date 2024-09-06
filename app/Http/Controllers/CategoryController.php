<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category; //LOAD MODEL CATEGORY

class CategoryController extends Controller
{
    public function index()
    {

        // urutkan berdasarkan dari yang terbaru, maksimal isi (pagitate 10)
        $category = Category::with(['parent'])->orderBy('created_at', 'DESC')->paginate(5);

        // mengambil data sesuai dengan urutan a-z
        $parent = Category::getParent()->orderBy('name', 'ASC')->get();
        return view('categories.index', compact('category', 'parent'));
    }



    public function store(Request $request)
    {

        // nama wajib isi isi , maksimal 50 karakter dan bersifat unik(tidak boleh sama dengan yang lain)
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories'
        ]);

        //FIELD slug AKAN DITAMBAHKAN KEDALAM COLLECTION $REQUEST
        $request->request->add(['slug' => $request->name]);

        //SEHINGGA PADA BAGIAN INI KITA TINGGAL MENGGUNAKAN $request->except()
        //YAKNI MENGGUNAKAN SEMUA DATA YANG ADA DIDALAM $REQUEST KECUALI INDEX _TOKEN
        //FUNGSI REQUEST INI SECARA OTOMATIS AKAN MENJADI ARRAY
        //CATEGORY::CREATE ADALAH MASS ASSIGNMENT UNTUK MEMBERIKAN INSTRUKSI KE MODEL AGAR MENAMBAHKAN DATA KE TABLE TERKAIT
        Category::create($request->except('_token'));

        return redirect(route('category.index'))->with(['success' => 'Category added successfully!']);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $parent = Category::getParent()->orderBy('name', 'ASC')->get();
        return view('categories.edit', compact('category', 'parent'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories,name,' . $id
        ]);

        $category = Category::find($id);
        $category->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);


        return redirect(route('category.index'))->with(['warning' => 'Category updated successfully!']);
    }
    public function destroy($id)
    {
        //TAMBAHKAN product KEDALAM ARRAY WITHCOUNT()
        //FUNGSI INI AKAN MEMBENTUK FIELD BARU YANG BERNAMA product_count
        $category = Category::withCount(['child', 'product'])->find($id);
        //KEMUDIAN PADA IF STATEMENTNYA KITA CEK JUGA JIKA = 0
        if ($category->child_count == 0 && $category->product_count == 0) {
            $category->delete();
            return redirect(route('category.index'))->with(['error' => 'The category has been deleted.']);
        }
        return redirect(route('category.index'))->with(['error' => 'Categories cannot be deleted while they are still being used for products.']);
    }


}
