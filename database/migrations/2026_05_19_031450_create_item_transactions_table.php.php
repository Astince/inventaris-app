<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('item_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->enum('transaction_type', ['in','out']);
            $table->integer('qty');
            $table->date('date');
            $table->string('source', 100)->nullable();
            $table->text('note')->nullable();
            $table->integer('stock_before')->default(0);
            $table->integer('stock_after')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('master_items')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('item_transactions'); }
};