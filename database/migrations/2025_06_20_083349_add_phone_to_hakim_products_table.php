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
    Schema::table('hakim_products', function (Blueprint $table) {
        $table->string('phone')->nullable()->after('status');
    });
}

public function down()
{
    // Schema::table('hakim_products', function (Blueprint $table) {
    //     $table->dropColumn('phone');
    // });
}

};
