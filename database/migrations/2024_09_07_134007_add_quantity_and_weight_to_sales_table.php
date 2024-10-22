<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->enum('quantity', ['1/4', '1/2', '3/4', '1'])->default('1'); // For sold animal quantity
        $table->decimal('weight', 8, 2)->nullable(); // For animal weight (with up to 2 decimal places)
    });
}

public function down()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->dropColumn('quantity');
        $table->dropColumn('weight');
    });
}
};
