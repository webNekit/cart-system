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
        Schema::create('repair_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            // Сделать part_id необязательным
            $table->foreignId('part_id')->nullable()->constrained('parts')->onDelete('cascade');

            $table->string('phone')->nullable();

            // Статус по умолчанию
            $table->enum('status', ['in_progress', 'completed', 'pending'])->default('in_progress');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->decimal('price', 10, 2)->nullable();
            $table->text('note')->nullable();

            // Сделать даты nullable, чтобы пользователь не заполнял
            $table->date('repair_start_date')->nullable();
            $table->date('repair_end_date')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_requests');
    }
};
