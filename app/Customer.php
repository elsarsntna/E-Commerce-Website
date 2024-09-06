<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];



    public function district()
    {
        return $this->belongsTo(District::class);
    }

    protected $appends = ['status_label'];
    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge rounded-pill bg-label-danger">Not Active</span>';
        }
        return '<span class="badge rounded-pill bg-label-success">Active</span>';
    }
}