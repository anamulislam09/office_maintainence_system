<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->integer('cat_id')->nullable();
            $table->string('sub_cat_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('name');
            $table->string('product_code');
            $table->string('serial_no')->nullable();
            $table->date('purchase_date')->nullable();
            $table->dauble('purchase_price', 20,2)->default(0);
            $table->integer('garranty')->nullable();
            $table->date('garranty_end_date')->nullable();
            $table->string('descriptions')->nullable();
            $table->enum('status',[1, 0, -1])->default(1);
            $table->tinyInteger('isassign')->default(0);
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
};
