<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date','value', 'original_data_full'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'original_data_full' => 'json',
    ];
}
