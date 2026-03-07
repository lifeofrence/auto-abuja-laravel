<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable();
            $table->text('business_address')->nullable();
            $table->string('business_location')->nullable();
            $table->string('association_or_union')->nullable();
            $table->string('service_type')->nullable();
            $table->string('service_category')->nullable();
            $table->text('service_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'business_address',
                'business_location',
                'association_or_union',
                'service_type',
                'service_category',
                'service_description'
            ]);
        });
    }
};
