<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('marketing_resources')) {
            Schema::table('marketing_resources', function (Blueprint $table) {
                if (!Schema::hasColumn('marketing_resources', 'badge')) {
                    $table->string('badge')->nullable()->after('category');
                }
            });
        }

        if (Schema::hasTable('agent_payout_requests')) {
            Schema::table('agent_payout_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('agent_payout_requests', 'agent_notes')) {
                    $table->string('agent_notes')->nullable()->after('account_number');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('marketing_resources')) {
            Schema::table('marketing_resources', function (Blueprint $table) {
                $table->dropColumn('badge');
            });
        }

        if (Schema::hasTable('agent_payout_requests')) {
            Schema::table('agent_payout_requests', function (Blueprint $table) {
                $table->dropColumn('agent_notes');
            });
        }
    }
};

