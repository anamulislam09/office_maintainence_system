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
        Schema::create('item_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('cat_id')->nullable();
            $table->string('sub_cat_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('brand_id')->nullable();
            $table->date('issue_date')->nullable();
            $table->string('serial_no')->nullable();
            $table->enum('status',[1, 0])->default(1);
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
        Schema::dropIfExists('item_masters');
    }
};
