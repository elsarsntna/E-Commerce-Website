<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $appends = ['status_label'];

    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span class="badge rounded-pill bg-label-primary">Waiting for Confirmation</span>';
        }
        return '<span class="badge rounded-pill bg-label-success">Accepted</span>';
    }


}