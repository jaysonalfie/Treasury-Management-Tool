<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferTransaction extends Model
{

   protected $guarded = ['id', 'created_at'];


     public function accountFrom(){

        return $this->belongsTo(Account::class, 'from_account_id');
     }

    public function accountTo(){

        return $this->belongsTo(Account::class, 'to_account_id');
    
    }

    public function creator(){

        return $this->belongsTo(User::class, 'created_by');
    }
}
