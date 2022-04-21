<?php

namespace App;

use App\TrashPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrashType extends Model
{
	use SoftDeletes;

    protected $table = 'trash_types';

    protected $fillable = [
    	'name', 'description', 'admin_id', 'status',
    ];

    public function trashprice()
    {
        return $this->hasMany(TrashPrice::class, 'trashtype_id');
    }

    public function admin()
    {
    	return $this->belongsTo('App\Admin');
    }
}
