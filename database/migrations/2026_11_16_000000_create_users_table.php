<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();

            // Nullable agar akun Google-only tidak wajib punya password SQL.
            $table->string('password')->nullable();

            $table->string('provider', 20)->default('sql');
            $table->string('google_id')->nullable()->unique();
            $table->text('avatar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
