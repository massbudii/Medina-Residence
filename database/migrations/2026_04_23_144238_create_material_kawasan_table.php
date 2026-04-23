<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_kawasan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('material_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->foreignId('type_unit_id')
                  ->constrained('type_units')
                  ->restrictOnDelete();

            $table->foreignId('kawasan_id')
                  ->constrained()
                  ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_kawasan');
    }
};
