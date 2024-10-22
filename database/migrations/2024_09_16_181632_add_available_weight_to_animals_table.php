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
        $table->decimal('available_weight', 8, 2)->default(0);
    });
}

public function down()
{
    Schema::table('animals', function (Blueprint $table) {
        $table->dropColumn('available_weight');
    });
}
};
