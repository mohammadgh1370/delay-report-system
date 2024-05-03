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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained('users');
            $table->foreignIdFor(\App\Models\Order::class)->unique()->constrained();
            $table->tinyInteger('status')
                ->default(\App\Enums\TripStatus::ASSIGNED)
                ->comment(\App\Enums\TripStatus::migrationComment());
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
