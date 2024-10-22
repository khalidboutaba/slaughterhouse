<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->text('components')->nullable(); // Store component names or details as a JSON string
    });
}

public function down()
{
    Schema::table('sales', function (Blueprint $table) {
        $table->dropColumn('components');
    });
}
};
