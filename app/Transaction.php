<?php

namespace App;

use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
    	'code', 'customer_id', 'admin_id', 'status', 'admin_fee', 'subtotal', 
    ];


    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }
    
    public function detailtransactions()
    {
        return $this->hasMany('App\DetailTransaction');
    }
}
