<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class User extends Eloquent implements \Illuminate\Contracts\Auth\Authenticatable,
                                       \Illuminate\Contracts\Auth\CanResetPassword
{
    use Authenticatable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}
