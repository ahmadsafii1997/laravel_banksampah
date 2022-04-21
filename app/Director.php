<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Director extends Authenticatable
{
    use SoftDeletes;

    protected $guard = 'director';

    protected $fillable = [
        'name', 'email', 'username', 'password','email_verfied_at', 'status'
    ];
}
