<?php

use App\Enums\CandidateStatusEnum;
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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 36)->unique();
            $table->string('name')->nullable();
            $table->string('email',200)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('country')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('status')->default(CandidateStatusEnum::ACTIVE->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
