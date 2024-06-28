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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->double('latitude', 10, 6)->nullable();
            $table->double('longitude', 10, 6)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('object_type_id')->nullable()->constrained('object_types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('deal_type_id')->nullable()->constrained('deal_types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('tariff_type_id')->nullable()->constrained('tariff_types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('parking_space_size_id')->nullable()->constrained('parking_space_sizes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('parking_space_number_id')->nullable()->constrained('parking_space_numbers')->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('price',8,2);
            $table->decimal('area', 8, 2);
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
