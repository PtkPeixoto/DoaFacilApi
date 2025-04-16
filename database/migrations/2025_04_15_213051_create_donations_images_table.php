<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('donation_id')->nullable();
            $table->text('image_base64');
            $table->timestamps();

            // Definindo as chaves estrangeiras
            $table->foreign('donation_id')->references('id')->on('donations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations_images');
    }
}
