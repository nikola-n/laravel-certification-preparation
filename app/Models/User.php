<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $appends = [
        'has_subscription',
    ];

    public function getHasSubscriptionAttribute()
    {
        return $this->attributes['subscription_type'] != '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected
        $guarded = [];

    protected
        $casts = [
        'fuck' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public
    function orders()
    {
        return $this->hasMany(Order::class);
    }

    ///**
    //* The attributes that should be visible in arrays.
    //*
    //* @var array
    //*/
    //protected
    //    $visible = ['name', 'email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected
        $hidden = [
        'password',
        'remember_token',
    ];

    ///**
    // * Retrieve the model for a bound value.
    // *
    // * @param mixed       $value
    // * @param string|null $field
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    //public function resolveRouteBinding($value, $field = null)
    //{
    //    return $this->where('name', $value)->firstOrFail();
    //}

    public
    function setNameAttribute($value
    ) {
        $this->attributes['name'] = strtolower($value);
    }

    public
    function getNameAttribute()
    {
        return strtoupper($this->attributes['name']);
    }

    public function getLowerCasedName()
    {
        //$this->getAttribute('name'); // NIKOLA
        //$this->attributes['name']; // nikola
        //$this->getNameAttribute(); // NIKOLA
        //$this->getOriginal('name')); // NIKOLA
    }

    //public static function handleLazyLoadingViolationUsing()
    //{
    //    return 'heeh';
    //}
}
