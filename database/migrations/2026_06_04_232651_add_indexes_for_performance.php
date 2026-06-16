<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('master_items', function (Blueprint $table) {
    $table->index('name');
    $table->index('category_id');
});
Schema::table('item_transactions', function (Blueprint $table) {
    $table->index('date');
    $table->index('transaction_type');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_items', function (Blueprint $table) {
    $table->dropIndex(['name']);
    $table->dropIndex(['category_id']);
});
Schema::table('item_transactions', function (Blueprint $table) {
    $table->dropIndex(['date']);
    $table->dropIndex(['transaction_type']);
});
    }
};
