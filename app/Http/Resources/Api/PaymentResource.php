<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "payment_date" => $this->payment_date->format('Y-m-d'),
            "expires_at" => $this->expires_at->format('Y-m-d'),
            "status" => $this->status,
            "user_id" => $this->client->user->id,
            "clp_usd" => $this->clp_usd,
        ];
    }
}
