<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
           $table->bigIncrements('id');
           $table->string('name');
           $table->string('slug');
           $table->unsignedBigInteger('category_id');
           $table->text('description')->nullable();
           $table->string('image');
           $table->integer('price');
           $table->integer('weight');
           $table->string('stock',10);
           $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories'); //table categories


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
