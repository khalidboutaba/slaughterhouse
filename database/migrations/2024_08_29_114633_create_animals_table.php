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
    Schema::create('animals', function (Blueprint $table) {
        $table->id();
        $table->string('type'); // 'cow', 'ram'
        $table->decimal('price', 10, 2);
        $table->decimal('weight', 8, 2); // Weight of the whole animal
        $table->decimal('entrails_price', 10, 2)->nullable(); // Price of entrails
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
