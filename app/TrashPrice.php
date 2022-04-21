<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class TrashPrice extends Model
{
    use SoftDeletes;

    protected $table = 'trash_prices';

    protected $fillable = [
    	'name', 'description', 'trashtype_id', 'price', 'unit', 'admin_id', 'status',
    ];

    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }

    public function trashtype()
    {
    	return $this->belongsTo('App\TrashType');
    }
}
