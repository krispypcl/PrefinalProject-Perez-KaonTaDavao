<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Pivot table for the many-to-many between eateries and features.
     * The name is the two singular table names in alphabetical order,
     * so Laravel finds it automatically in belongsToMany().
     */
    public function up(): void
    {
        Schema::create('eatery_feature', function (Blueprint $table) {
            // no id() column on purpose
            $table->foreignId('eatery_id')->constrained();
            $table->foreignId('feature_id')->constrained();

            // composite primary key: the same eatery + feature pair can only exist once
            $table->primary(['eatery_id', 'feature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eatery_feature');
    }
};
