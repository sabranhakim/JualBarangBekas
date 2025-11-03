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
        if (!Schema::hasColumn('hakim_products', 'phone')) {
            $table->string('phone');
        }
    });
}

public function down()
{
    Schema::table('hakim_products', function (Blueprint $table) {
        $columns = ['phone'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('hakim_products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
}

};
