<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    //MEMBUAT RELASI KE MODEL DISTRICT.PHP
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    protected $appends = ['status_label'];

    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge rounded-pill bg-label-primary">New</span>';
        } elseif ($this->status == 1) {
            return '<span class="badge rounded-pill bg-label-secondary">Comfirm</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge rounded-pill bg-label-info">Process</span>';
        } elseif ($this->status == 3) {
            return '<span class="badge rounded-pill bg-label-warning">Shipping</span>';
        }
        return '<span class="badge rounded-pill bg-label-success">Finished</span>';
    }



    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function return()
    {
        return $this->hasOne(OrderReturn::class);
    }

}
