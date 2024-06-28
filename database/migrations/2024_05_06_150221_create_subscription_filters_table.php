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
        Schema::create('subscription_filters', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->integer('distance')->nullable();
            $table->double('latitude', 10, 6)->nullable();
            $table->double('longitude', 10, 6)->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('object_type_id')->nullable()->constrained('object_types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('deal_type_id')->nullable()->constrained('deal_types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('tariff_type_id')->nullable()->constrained('tariff_types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('parking_space_size_id')->nullable()->constrained('parking_space_sizes')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('parking_space_number_id')->nullable()->constrained('parking_space_numbers')->cascadeOnUpdate()->nullOnDelete();
            $table->decimal('min_price',16,2)->nullable();
            $table->decimal('max_price',16,2)->nullable();
            $table->decimal('min_area',8,2)->nullable();
            $table->decimal('max_area',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_filters');
    }
};
