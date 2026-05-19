<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('unit_id');
            $table->integer('stock')->default(0);
            $table->integer('min_stock');
            $table->string('location', 100)->nullable();
            $table->enum('status', ['active','inactive'])->default('active');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('master_category')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('master_items'); }
};
