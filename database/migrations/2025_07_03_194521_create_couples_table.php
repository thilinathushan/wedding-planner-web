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
        Schema::create('couples', function (Blueprint $table) {
            $table->id();
            // This is the user who creates the plan. constrained() links it to the 'users' table.
            $table->foreignId('user1_id')->constrained('users')->onDelete('cascade');
            // This is the partner who joins later. Also linked to users.
            $table->foreignId('user2_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('partner_email_invite')->nullable();
            $table->date('wedding_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couples');
    }
};
