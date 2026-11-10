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
        // 1. Table to store incoming SMS / bKash notifications intercepted by Android App
        if (!Schema::hasTable('received_sms_notifications')) {
            Schema::create('received_sms_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('gateway', 30)->default('bkash');
                $table->string('sender_number', 50)->nullable();
                $table->decimal('amount', 12, 2);
                $table->string('trx_id', 100)->index();
                $table->text('raw_notification')->nullable();
                $table->string('status', 30)->default('unmatched'); // unmatched, matched, ignored
                $table->unsignedBigInteger('matched_order_id')->nullable();
                $table->string('device_info', 255)->nullable();
                $table->timestamps();
            });
        }

        // 2. Add extra tracking fields to plan_orders
        if (Schema::hasTable('plan_orders')) {
            Schema::table('plan_orders', function (Blueprint $table) {
                if (!Schema::hasColumn('plan_orders', 'sender_number')) {
                    $table->string('sender_number', 50)->nullable()->after('payment_type');
                }
                if (!Schema::hasColumn('plan_orders', 'verified_at')) {
                    $table->timestamp('verified_at')->nullable()->after('payment_status');
                }
                if (!Schema::hasColumn('plan_orders', 'verified_by')) {
                    $table->string('verified_by', 50)->nullable()->after('verified_at'); // android_app, manual_admin
                }
                if (!Schema::hasColumn('plan_orders', 'admin_notes')) {
                    $table->text('admin_notes')->nullable()->after('verified_by');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_sms_notifications');
        if (Schema::hasTable('plan_orders')) {
            Schema::table('plan_orders', function (Blueprint $table) {
                $table->dropColumn(['sender_number', 'verified_at', 'verified_by', 'admin_notes']);
            });
        }
    }
};

