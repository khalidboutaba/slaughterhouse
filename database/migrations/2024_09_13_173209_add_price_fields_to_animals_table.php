<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->decimal('price_per_kg', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn('price_per_kg');
            $table->dropColumn('total_price');
        });
    }
};
