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
        if (!Schema::hasColumn('animals', 'supplier_id')) {
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
        }

        if (!Schema::hasColumn('animals', 'origin')) {
            $table->string('origin')->nullable();
        }

        if (!Schema::hasColumn('animals', 'reference')) {
            $table->string('reference')->unique();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn(['supplier_id', 'origin', 'reference']);
        });
    }
};
