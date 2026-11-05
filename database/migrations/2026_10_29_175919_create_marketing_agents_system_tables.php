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
        // 1. Marketing Agents Table
        if (!Schema::hasTable('marketing_agents')) {
            Schema::create('marketing_agents', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('referral_code')->unique();
                $table->decimal('commission_rate', 5, 2)->default(15.00); // e.g. 15%
                $table->string('commission_type')->default('percentage'); // 'percentage' or 'fixed'
                $table->string('payment_method')->nullable(); // e.g. 'bKash', 'Nagad', 'Rocket', 'Bank'
                $table->string('payout_details')->nullable(); // Account number or phone
                $table->boolean('is_active')->default(true);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 2. Add referred_by_agent_id to users table
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'referred_by_agent_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('referred_by_agent_id')->nullable()->after('created_by');
                $table->foreign('referred_by_agent_id')->references('id')->on('marketing_agents')->onDelete('set null');
            });
        }

        // 3. Agent Targets / Incentive Campaigns Table
        if (!Schema::hasTable('agent_targets')) {
            Schema::create('agent_targets', function (Blueprint $table) {
                $table->id();
                $table->string('title'); // e.g. "সাপ্তাহিক মেগা বোনাস - ১৫ সাবস্ক্রিপশন"
                $table->integer('target_count')->default(15);
                $table->string('period_type')->default('weekly'); // 'weekly', 'monthly', 'custom'
                $table->decimal('bonus_amount', 10, 2)->default(2000.00); // Extra cash bonus
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 4. Agent Commissions & Earnings Table
        if (!Schema::hasTable('agent_commissions')) {
            Schema::create('agent_commissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('agent_id');
                $table->unsignedBigInteger('user_id')->nullable(); // The referred merchant who subscribed
                $table->string('plan_order_id')->nullable();
                $table->unsignedBigInteger('plan_id')->nullable();
                $table->string('plan_name')->nullable();
                $table->decimal('plan_price', 10, 2)->default(0.00);
                $table->decimal('commission_rate', 5, 2)->default(0.00);
                $table->decimal('commission_amount', 10, 2)->default(0.00);
                $table->unsignedBigInteger('bonus_target_id')->nullable();
                $table->decimal('bonus_amount', 10, 2)->default(0.00);
                $table->string('status')->default('pending'); // 'pending', 'paid', 'cancelled'
                $table->dateTime('payout_date')->nullable();
                $table->string('payout_method')->nullable();
                $table->string('payout_trx_id')->nullable();
                $table->text('payout_notes')->nullable();
                $table->timestamps();

                $table->foreign('agent_id')->references('id')->on('marketing_agents')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_commissions');
        Schema::dropIfExists('agent_targets');
        if (Schema::hasColumn('users', 'referred_by_agent_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['referred_by_agent_id']);
                $table->dropColumn('referred_by_agent_id');
            });
        }
        Schema::dropIfExists('marketing_agents');
    }
};
