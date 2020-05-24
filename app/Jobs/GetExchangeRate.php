<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use App\Models\Api\ExchangeRate;

class GetExchangeRate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $date;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($date)
    {
        $this->date = $date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $exchangeRate = ExchangeRate::whereDate('date',$this->date)->first();

        if (empty($exchangeRate)) {

            $baseUrl = env('API_MINDICADOR_ENDPOINT');
            $client = new Client(['base_uri' => $baseUrl]);

            $response = $client->request('GET', $baseUrl.now()->parse($this->date)->format('d-m-Y'));
            $data = json_decode($response->getBody());

            if (empty($data->serie)) {
                return false;
            }

            ExchangeRate::create([
                'date' => $this->date,
                'value' => $data->serie[0]->valor,
                'original_data_full' => $data,
            ]);
        }
    }
}
