<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->string('purchase_status')->default('not_paid'); // Add purchase_status with default value
        });
    }

    public function down()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn('purchase_status');
        });
    }
};
