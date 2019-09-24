<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoplistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoplist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('shop_name');
            $table->string('owner_name');
            $table->string('contact')->nullable();
            $table->text('address')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('shoplist');
    }
}
