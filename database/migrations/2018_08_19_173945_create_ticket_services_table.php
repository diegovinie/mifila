<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('duration');    // en segundos
            $table->DateTime('due');                // fecha de cierre
            $table->unsignedInteger('ticket_id');
            $table->unsignedInteger('cashier_id');
            $table->unsignedInteger('agency_id');
            $table->unsignedInteger('quality')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')
                ->references('id')->on('tickets')
                ->onDelete('cascade');
            $table->foreign('cashier_id')
                ->references('id')->on('cashiers')
                ->onDelete('cascade');
            $table->foreign('agency_id')
                ->references('id')->on('agencies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_services');
    }
}
