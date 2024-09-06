<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->unsignedBigInteger('district_id');
            $table->integer('subtotal');
            $table->char('status', 1)->default(0)->comment('0: new, 1: confirm, 2: process, 3: shipping, 4: done');
            $table->string('tracking_number')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers'); //table 
            $table->foreign('district_id')->references('id')->on('districts'); //table 




           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
