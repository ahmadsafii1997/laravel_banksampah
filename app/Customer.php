<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Transaction;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Authenticatable
{
    use SoftDeletes;

    protected $guard = 'customer';

    protected $fillable = [
        'nik', 'name', 'username', 'password', 'address', 'phone', 'status', 'earning',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

