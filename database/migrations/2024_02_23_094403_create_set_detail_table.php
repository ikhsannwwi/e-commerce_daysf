<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_id');
            $table->string('nama');
            $table->decimal('harga', 32, 2);
            $table->string('foto');
            $table->text('link');
            $table->text('deskripsi');
            $table->timestamps();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('set_detail');
    }
}
