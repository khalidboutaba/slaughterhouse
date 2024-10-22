<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('animals', function (Blueprint $table) {
        $table->text('note')->nullable()->after('entrails_price');
    });
}

public function down()
{
    Schema::table('animals', function (Blueprint $table) {
        $table->dropColumn('note');
    });
}
};
