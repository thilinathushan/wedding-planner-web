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
        Schema::create('partner_invites', function (Blueprint $table) {
            $table->id();
            // Link to the couple record this invitation belongs to.
            // If the couple record is deleted, this invite is deleted too.
            $table->foreignId('couple_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->string('token')->unique();
            $table->timestamp('expires_at');
            // This is our state machine: pending, accepted, expired
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_invites');
    }
};
