<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delay_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Order::class)->constrained();
            $table->foreignIdFor(\App\Models\Agent::class)->nullable()->constrained();
            $table->timestamp('checked_at')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE delay_reports ADD unique_order_id_agent_id_checked_at_md5 char(32) AS (MD5(CONCAT(order_id, ifnull(agent_id, 0), ifnull(checked_at , 0)))) UNIQUE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delay_reports');
    }
};
