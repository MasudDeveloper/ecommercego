<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('marketing_resources')) {
            // Using raw statement for maximum cross-database compatibility (MySQL / MariaDB)
            DB::statement("ALTER TABLE `marketing_resources` MODIFY `category` VARCHAR(50) NOT NULL DEFAULT 'inbox_script'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('marketing_resources')) {
            DB::statement("ALTER TABLE `marketing_resources` MODIFY `category` ENUM('inbox_script', 'comment_script', 'objection_handling', 'banner', 'video_guide') NOT NULL DEFAULT 'inbox_script'");
        }
    }
};
