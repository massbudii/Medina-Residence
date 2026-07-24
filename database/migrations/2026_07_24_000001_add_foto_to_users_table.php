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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp', 500)->nullable()->after('foto');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('email', 500)->change();
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('no_hp', 500)->change();
            $table->text('alamat_supplier')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'foto')) {
                $table->dropColumn('foto');
            }
            if (Schema::hasColumn('users', 'no_hp')) {
                $table->dropColumn('no_hp');
            }
        });
    }
};
