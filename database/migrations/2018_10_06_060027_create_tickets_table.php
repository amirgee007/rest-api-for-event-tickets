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

            $table->bigIncrements('ticket_id');
            $table->string('uid', 100);

            $table->bigInteger('event_id')->unsigned()->index();
            $table->bigInteger('event_ticket_id')->unsigned()->index();

            $table->tinyInteger('is_free')->default(0)->comment(' 1 : Free , 0 Paid');

            $table->string('title');
            $table->string('description')->nullable();

            $table->string('ticket_price_tag')->nullable()->comment('what shows on the ticket stub');
            $table->string('service_charge')->nullable()->comment('what application will charge');

            $table->tinyInteger('is_fee_absorbed')->default(0)->comment(' 0 : buyer pays the fee , 1 : Seller pays the fee');

            $table->tinyInteger('has_sale_date')->default(0);

            $table->timestamp('sale_start_time')->nullable();
            $table->timestamp('sale_end_time')->nullable();

            $table->integer('ticket_sell_limit')->comment('Total number of available tickets');
            $table->tinyInteger('ticket_buy_limit')->nullable()->comment('Maximum number of ticket can be purchased by an account');

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
        Schema::dropIfExists('tickets');
    }
}
