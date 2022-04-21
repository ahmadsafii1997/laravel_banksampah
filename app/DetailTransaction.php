<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'detail_transactions';

    protected $fillable = [
    	'transaction_id', 'trashprice_id', 'trashtype_id', 'qty', 'price', 'admin_fee', 'subtotal', 'status',
    ];

    public function transaction()
    {
    	return $this->belongsTo('App\Transaction');
    }

    public function trashprice()
    {
    	return $this->belongsTo('App\TrashPrice');
    }

    public function trashtype()
    {
    	return $this->belongsTo('App\TrashType');
    }

}
