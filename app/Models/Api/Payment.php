<?php

namespace App\Models\Api;

use App\Models\Api\Client;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id', 'uuid', 'payment_date', 'expires_at', 'status', 'clp_usd'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'payment_date' => 'date',
        'expires_at' => 'date',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
    	'saved' => \App\Events\PaymentSaved::class,
	];

    /**
     * Get client associated with the user.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
