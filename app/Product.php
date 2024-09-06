<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{

    //INI ADALAH ACCESSOR, JADI KITA MEMBUAT KOLOM BARU BERNAMA STATUS_LABEL
//KOLOM TERSEBUT DIHASILKAN OLEH ACCESSOR, MESKIPUN FIELD TERSEBUT TIDAK ADA DITABLE PRODUCTS
//AKAN TETAPI AKAN DISERTAKAN PADA HASIL QUERY
    public function getStatusLabelAttribute()
    {
        //ADAPUN VALUENYA AKAN MENCETAK HTML BERDASARKAN VALUE DARI FIELD STATUS
        if ($this->status == 0) {
            return '<span class="badge rounded-pill bg-label-secondary">Draft</span>';
        }
        return '<span class="badge rounded-pill bg-label-success">Publish</span>';
    }

    //FUNGSI YANG MENG-HANDLE RELASI KE TABLE CATEGORY
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //JIKA FILLABLE AKAN MENGIZINKAN FIELD APA SAJA YANG ADA DIDALAM ARRAYNYA
//MAKA GUARDED AKAN MEMBLOK FIELD APA SAJA YANG ADA DIDALAM ARRAY-NYA
//JADI APABILA FIELDNYA BANYAK MAKA KITA BISA MANFAATKAN DENGAN HANYA MENULISKAN ARRAY KOSONG
//YANG BERARTI TIDAK ADA FIELD YANG DIBLOCK SEHINGGA SEMUA FIELD TERSEBUT SUDAH DIIZINAKAN
//HAL INI MEMUDAHKAN KITA KARENA TIDAK PERLU MENULISKANNYA SATU PERSATU
    protected $guarded = [];

    //SEDANGKAN INI ADALAH MUTATORS, PENJELASANNYA SAMA DENGAN ARTIKEL SEBELUMNYA
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function product()
    {
        //JENIS RELASINYA ADALAH ONE TO MANY, YANG BERARTI KATEGORI INI BISA DIGUNAKAN OLEH BANYAK PRODUK
        return $this->hasMany(Product::class);
    }

    public function setDraftIfOutOfStock()
    {
        if ($this->stock <= 0) {
            $this->update(['status' => '0']);
        }
    }
}
