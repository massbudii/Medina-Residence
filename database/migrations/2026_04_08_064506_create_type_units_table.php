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
        Schema::create('type_units', function (Blueprint $table) {
            $table->id();
            $table->string('nama_type', 50)->unique();
            $table->integer('luas_bangunan');
            $table->integer('luas_tanah');
            $table->decimal('harga_rumah', 15 , 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_units');
    }
};
