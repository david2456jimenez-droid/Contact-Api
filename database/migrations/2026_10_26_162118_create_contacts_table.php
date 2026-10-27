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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('User_id')->constrained('users')->cascadeOnDelete(); // estableciendo la relación con la tabla users
            $table->string('first_name', 45);
            $table->string('last_name', 45)->nullable(); // este campo es opcional, ya que es decisión del usuario si desea agregarlo o no
            $table->string('phone_number', 50)->unique(); // este campo debe ser único 
            $table->string('email', 100)->unique();
            $table->string('address', 100);
            $table->string('avatar_url', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
