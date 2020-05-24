<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Client;
use App\Http\Resources\Api\PaymentResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Jobs\GetExchangeRate;
use App\Models\Api\Payment;

class PaymentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'client_id' => 'required',
            'payment_date' => 'required|date',
            'expires_at' => 'required|date',
            'status' => 'required',
            'clp_usd' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                "message" => "validation error",
                "errors" => $validation->errors()
            ]);
        }

        GetExchangeRate::dispatch($request->payment_date);

        $request['uuid'] = Str::uuid();

        $payment = Payment::create($request->all());

        return (new PaymentResource($payment))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       $client_id = $request->get('client');

        $client = Client::find($client_id);

        if (empty($client)) {
            return response()->json(['message' => "Client not found"], 404);
        }

        return PaymentResource::collection($client->payments);
    }
}
