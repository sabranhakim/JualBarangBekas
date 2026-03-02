<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hakim_orders', function (Blueprint $table) {
            $table->string('payment_gateway')->nullable()->after('status');
            $table->string('payment_reference')->nullable()->unique()->after('payment_gateway');
            $table->string('payment_url')->nullable()->after('payment_reference');
            $table->timestamp('paid_at')->nullable()->after('payment_url');
            $table->json('payment_payload')->nullable()->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('hakim_orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'payment_reference',
                'payment_url',
                'paid_at',
                'payment_payload',
            ]);
        });
    }
};
