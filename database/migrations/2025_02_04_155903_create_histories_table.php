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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('material_id');
            $table->double('quantity');
            $table->double('previous_value')->nullable();
            $table->double('current_value')->nullable();
            $table->unsignedBigInteger('from_id');
            $table->unsignedSmallInteger('to_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
