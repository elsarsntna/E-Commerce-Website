<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $fillable = ['customer_id', 'product_id', 'qty', 'product_name', 'product_price', 'product_image'];
}
