<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add auth and profile columns to marketing_agents
        if (Schema::hasTable('marketing_agents')) {
            Schema::table('marketing_agents', function (Blueprint $table) {
                if (!Schema::hasColumn('marketing_agents', 'password')) {
                    $table->string('password')->default(Hash::make('12345678'))->after('email');
                }
                if (!Schema::hasColumn('marketing_agents', 'remember_token')) {
                    $table->rememberToken()->after('password');
                }
                if (!Schema::hasColumn('marketing_agents', 'rank_badge')) {
                    $table->string('rank_badge')->default('bronze')->after('referral_code');
                }
                if (!Schema::hasColumn('marketing_agents', 'avatar')) {
                    $table->string('avatar')->nullable()->after('rank_badge');
                }
            });
        }

        // 2. Mini CRM: Agent Leads Table
        if (!Schema::hasTable('agent_leads')) {
            Schema::create('agent_leads', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('agent_id');
                $table->string('shop_name');
                $table->string('owner_name')->nullable();
                $table->string('phone');
                $table->string('page_url')->nullable();
                $table->string('category')->nullable(); // e.g. Clothing, Gadgets, Honey/Food, Cosmetics, etc.
                $table->enum('status', ['new', 'contacted', 'trial_started', 'converted', 'follow_up', 'lost'])->default('new');
                $table->date('follow_up_date')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->foreign('agent_id')->references('id')->on('marketing_agents')->onDelete('cascade');
            });
        }

        // 3. Agent Payout / Withdrawal Requests Table
        if (!Schema::hasTable('agent_payout_requests')) {
            Schema::create('agent_payout_requests', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('agent_id');
                $table->decimal('amount', 10, 2);
                $table->string('payment_method')->default('bKash'); // bKash, Nagad, Rocket, Bank
                $table->string('account_number');
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->string('transaction_id')->nullable();
                $table->text('admin_note')->nullable();
                $table->timestamps();

                $table->foreign('agent_id')->references('id')->on('marketing_agents')->onDelete('cascade');
            });
        }

        // 4. Marketing Resources & Playbook CMS Table
        if (!Schema::hasTable('marketing_resources')) {
            Schema::create('marketing_resources', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->enum('category', ['inbox_script', 'comment_script', 'objection_handling', 'banner', 'video_guide'])->default('inbox_script');
                $table->text('content_text');
                $table->string('media_url')->nullable();
                $table->integer('order_priority')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_resources');
        Schema::dropIfExists('agent_payout_requests');
        Schema::dropIfExists('agent_leads');

        if (Schema::hasTable('marketing_agents')) {
            Schema::table('marketing_agents', function (Blueprint $table) {
                $table->dropColumn(['password', 'remember_token', 'rank_badge', 'avatar']);
            });
        }
    }
};

