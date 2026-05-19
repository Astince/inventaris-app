<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('master_unit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('master_unit'); }
};