<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // jis user ko task assign hua
            $table->foreignId('user_id')
                  ->constrained()
                  ->restrictOnDelete();

            // admin jisne task diya
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->restrictOnDelete();

            // task fields
            $table->string('title');                 // REQUIRED
            $table->text('task_details');
            $table->text('work_update')->nullable();
            $table->date('start_date');
            $table->date('due_date');

            $table->enum('status', ['pending', 'completed'])
                  ->default('pending');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
