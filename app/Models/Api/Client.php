<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use App\Models\Api\Payment;

class Client extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','uuid', 'number', 'name', 'address', 'email', 'join_date'];

    /**
     * Get  payments record associated with the customer.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
