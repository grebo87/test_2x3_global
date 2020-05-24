<?php

use Illuminate\Database\Seeder;
use App\Models\Api\Client;
use App\Models\Api\Payment;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
       	DB::table('users')->delete();

       	factory(App\User::class, 10)->create()->each(function ($user) {
        	$user->client()->save(factory(Client::class)->make());
    	});
    }
}
