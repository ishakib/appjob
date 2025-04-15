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
        Schema::create('metafields', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 36)->unique();
            $table->morphs('metafieldable');
            $table->string('namespace')->default('global');
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('value_type')->default('string');
            $table->timestamps();

            $table->unique(['metafieldable_type', 'metafieldable_id', 'namespace', 'key'], 'unique_metafield');
            $table->index(['namespace', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metafields');
    }
};
