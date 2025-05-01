<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToRescuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rescues', function (Blueprint $table) {
            $table->string('rescue_token')->nullable()->after('rescued_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rescues', function (Blueprint $table) {
            $table->dropColumn('rescue_token'); // Remove a coluna 'status' ao reverter
        });
    }
}
