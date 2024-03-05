<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDataImageToSetDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('set_detail', function (Blueprint $table) {
            $table->bigInteger('data_image_width')->nullable();
            $table->bigInteger('data_image_height')->nullable();
            $table->bigInteger('data_image_x')->nullable();
            $table->bigInteger('data_image_y')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('set_detail', function (Blueprint $table) {
            //
        });
    }
}
