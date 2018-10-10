<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id')->unsigned()->index();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->enum('status',['awaiting_payment', 'payment_received']);
            $table->string('payment_token')->nullable();
            $table->timestamps();

//            $table->foreign ('ticket_id')->references('ticket_id')->on('tickets')->onDelete('cascade');
//            $table->foreign ('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_logs');
    }
}
