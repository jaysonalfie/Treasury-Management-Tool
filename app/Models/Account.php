<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $guarded = ['id', 'created_at'];

    public function creator(){

        return $this->belongsTo(User::class, 'created_by');
    }
}
