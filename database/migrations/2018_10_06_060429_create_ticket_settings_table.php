<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_ticket_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid', 100);
            $table->bigInteger('event_id')->unsigned()->index();

            $table->string('currency', 3)->default('USD');
            $table->string('country', 3)->default('US');
            $table->bigInteger('payment_account')->nullable()->comment('The account id that the event planner get paied for this event');
            $table->tinyInteger('show_remaining')->default(0);

            $table->timestamp('sale_start_time')->nullable()->comment('Tickets will be available after this time');
            $table->timestamp('sale_end_time')->nullable()->comment('Tickets will not be available after this time');

            $table->timestamps();

            //$table->foreign ('event_id')->references('event_id')->on('events')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_settings');
    }
}
