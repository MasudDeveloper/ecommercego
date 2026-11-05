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
        if (Schema::hasTable('marketing_agents')) {
            Schema::table('marketing_agents', function (Blueprint $table) {
                if (!Schema::hasColumn('marketing_agents', 'approval_status')) {
                    $table->string('approval_status', 20)->default('approved')->after('is_active');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('marketing_agents')) {
            Schema::table('marketing_agents', function (Blueprint $table) {
                if (Schema::hasColumn('marketing_agents', 'approval_status')) {
                    $table->dropColumn('approval_status');
                }
            });
        }
    }
};
