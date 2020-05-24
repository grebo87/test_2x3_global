<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("uuid");
            $table->unsignedBigInteger('client_id');
            $table->date("payment_date");
            $table->date("expires_at");
            $table->string("status");
            $table->decimal("clp_usd");
            $table->timestamps();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
