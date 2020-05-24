<?php

use Illuminate\Database\Seeder;
use App\Models\Api\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Client::truncate();

       factory(Client::class, 10)->create();
    }
}
