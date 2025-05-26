<?php

use App\Models\Character;
use App\Models\Comic;
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
        Schema::create('character_comic', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Character::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Comic::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_comic');
    }
};
