<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num');
            $table->unsignedInteger('client_id');
            $table->unsignedInteger('agency_id')->default(1);
            $table->boolean('pending')->default(true);
            $table->boolean('delayed')->default(false);
            $table->boolean('notificable')->default(false);
            $table->unsignedInteger('waited')->nullable();  // segundos totales de espera
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
