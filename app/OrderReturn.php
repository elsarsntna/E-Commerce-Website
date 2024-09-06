<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    protected $guarded = [];
    protected $appends = ['status_label'];


    public function getStatusLabelAttribute()
    {

        if ($this->status == 0) {
            return '<span class="badge rounded-pill bg-label-secondary">Waiting for Confirmation</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge rounded-pill bg-label-danger">Rejected</span>';
        }
        return '<span class="badge rounded-pill bg-label-success ">Finish</span>';
    }
}
