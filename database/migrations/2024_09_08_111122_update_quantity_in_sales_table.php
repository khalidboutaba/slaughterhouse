<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Change the quantity field to decimal, with 8 total digits and 2 decimal places
            $table->decimal('quantity', 8, 2)->default(1)->change();
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Revert back to enum if necessary (use with caution if data exists)
            $table->enum('quantity', ['1/4', '1/2', '3/4', '1'])->default('1')->change();
        });
    }
};
