<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintsToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
            $table->foreign('client_id')
                ->references('id')->on('clients')
                ->onDelete('no action');
            $table->foreign('agency_id')
                ->references('id')->on('agencies')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
            $table->dropForeign('tickets_client_id_foreign');
            $table->dropForeign('tickets_agency_id_foreign');
        });
    }
}
