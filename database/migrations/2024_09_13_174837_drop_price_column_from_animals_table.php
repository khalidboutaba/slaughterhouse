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
        $table->dropColumn('price');
    });
}

public function down()
{
    Schema::table('animals', function (Blueprint $table) {
        $table->decimal('price', 8, 2)->nullable(); // Recreate the column if you need to rollback
    });
}
};
