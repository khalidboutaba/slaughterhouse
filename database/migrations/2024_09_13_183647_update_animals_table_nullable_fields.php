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
            // Modify existing columns to be nullable
            $table->string('origin')->nullable()->change();
            $table->string('reference')->nullable()->change();
            $table->text('note')->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animals', function (Blueprint $table) {
            // Reverse the changes if needed
            $table->string('origin')->nullable(false)->change();
            $table->string('reference')->nullable(false)->change();
            $table->text('note')->nullable(false)->change();

        });
    }
};
