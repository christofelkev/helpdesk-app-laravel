<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // Format: TICKET-2023-001
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['open', 'in_progress', 'pending', 'resolved', 'closed', 'reopened'])->default('open');
            // Using Foreign Key for priority instead of Enum
            $table->foreignId('priority_id')->constrained('priorities')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->date('due_date')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('ticket_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
