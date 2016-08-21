<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'first_name', 'last_name', 'mobile',
        'email', 'password', 'profile_pic',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'is_admin', 'password', 'remember_token',
    ];

    const DEFAULT_PROFILE_PIC = 'http://viverealmeglio.it/wp-content/uploads/2015/01/uova-colesterolo.png';

    /**
     * Get the products owned (created) by this User
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Checks if the User is admin
     *
     * @returns boolean
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
