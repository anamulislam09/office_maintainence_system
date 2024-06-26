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
        Schema::create('product_allocates', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('office_id');
            $table->date('assign_date');
            $table->date('updated_date');
            $table->enum('status',[1, 0, -1])->default(1);
            $table->enum('location',[1, 2, 3, 4, 5])->default(1);
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
        Schema::dropIfExists('product_allocates');
    }
};
