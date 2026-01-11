<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sla_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('priority_id')->constrained('priorities')->onDelete('cascade');
            $table->timestamp('expected_response_time')->nullable();
            $table->timestamp('expected_resolution_time')->nullable();
            $table->timestamp('actual_response_time')->nullable();
            $table->timestamp('actual_resolution_time')->nullable();
            $table->boolean('response_breached')->default(false);
            $table->boolean('resolution_breached')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sla_logs');
    }
};
