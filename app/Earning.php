<?php

namespace App;

use App\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Earning extends Model
{
    use SoftDeletes;

    protected $table = 'earnings';

    protected $fillable = [
    	'customer_id', 'admin_id', 'amount', 'status',
    ];

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }
}
