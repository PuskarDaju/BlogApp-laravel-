<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('connection', function (Blueprint $table) {
            $table->foreignId('id1')->constrained('users')->onDelete('cascade');
            $table->foreignId('id2')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('sentBy')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connection');
    }
};
