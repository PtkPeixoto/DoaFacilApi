<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRescuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rescues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('donation_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('rescue_date')->nullable();
            $table->integer('rescued_quantity')->nullable();
            $table->timestamps();

            // Definindo as chaves estrangeiras
            $table->foreign('donation_id')->references('id')->on('donations')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rescues');
    }
}
