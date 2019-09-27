<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cate_name', 191);
            $table->string('img_path', 191);
            $table->integer('status')->default(1)->comment('1 = Active, 0 = De-Active');
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
        Schema::dropIfExists('top_category');
    }
}
