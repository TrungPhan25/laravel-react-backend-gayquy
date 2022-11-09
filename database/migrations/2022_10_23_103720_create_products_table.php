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
            $table->id();
            $table->string('categorySlug');
            $table->string('slug');
            $table->string('title');
            $table->mediumText('description');
            $table->string('selling_price');
            $table->string('original_price');
            $table->string('qty');
            $table->string('image01')->nullable();
            $table->string('image02')->nullable();
            $table->json('size')->nullable();
            $table->string('status')->default('0');
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
        Schema::dropIfExists('products');
    }
}
