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
        Schema::create('f_a_q_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('f_a_q_category_id')->constrained()->onDelete('cascade');
            $table->string('question');
            $table->text('answer');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('f_a_q_items');
    }
};
