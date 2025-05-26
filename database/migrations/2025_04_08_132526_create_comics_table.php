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
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('artist');
            $table->text('description');
            $table->double('price');
            $table->integer('stock');
            $table->string('thumbnail_image')->nullable();
            $table->string('type');
            $table->integer('pages');
            $table->double('weight');
            $table->string('slug')->unique();
            $table->foreignIdFor(\App\Models\Publisher::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};
