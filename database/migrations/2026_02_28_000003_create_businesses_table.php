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
        Schema::create('businesses', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->nullOnDelete();
            $table->string('business_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('address');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('phone', 20);
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->json('business_hours')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'disabled'])->default('pending');
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->decimal('rating_average', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);
            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->index('status');
            $table->index('is_featured');
            // Fulltext manually added in up() if needed, skip for now to avoid issues
            // $table->fullText(['business_name', 'description', 'address']);
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
