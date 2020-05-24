<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use App\Jobs\GetExchangeRate;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/clients', function (Request $request) {
    return App\Http\Resources\Api\ClientResource::collection(App\Models\Api\Client::all());
});

Route::get('/payments', function (Request $request) {

    $client_id = $request->get('client');

    $client = App\Models\Api\Client::find($client_id);

    if (empty($client)) {
    	return response()->json(['message' => "Client not found"], 404);
    }

    return App\Http\Resources\Api\PaymentResource::collection($client->payments);
});


Route::post('/payments', function (Request $request) {

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

	$payment = App\Models\Api\Payment::create($request->all());

	return (new App\Http\Resources\Api\PaymentResource($payment))
		->response()
        ->setStatusCode(201);
});

