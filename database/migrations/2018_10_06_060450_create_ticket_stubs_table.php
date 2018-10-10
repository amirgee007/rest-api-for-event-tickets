<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketStubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_stubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->unsigned()->index();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('barcode');
            $table->integer('row_number');
            $table->integer('section_number');
            $table->string('group');
            $table->tinyInteger('is_used')->default(0)->comment('When user attend in an event, we need to redeem the individual tickets');;
            $table->timestamps();

//            $table->foreign ('ticket_id')->references('ticket_id')->on('tickets')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_stubs');
    }
}
