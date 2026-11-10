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
        // 1. Create Abandoned Carts Table for 1-Click WhatsApp Recovery
        if (!Schema::hasTable('abandoned_carts')) {
            Schema::create('abandoned_carts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('store_id')->default(1)->index();
                $table->unsignedBigInteger('product_id')->nullable();
                $table->string('product_name')->nullable();
                $table->decimal('product_price', 12, 2)->default(0.00);
                $table->string('customer_name')->nullable();
                $table->string('customer_phone')->index();
                $table->text('customer_address')->nullable();
                $table->string('ip_address')->nullable();
                $table->enum('status', ['abandoned', 'recovered'])->default('abandoned');
                $table->text('recovery_note')->nullable();
                $table->timestamps();
            });
        }

        // 2. Add Courier & Delivery Tracking Columns to Orders Table
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'courier_name')) {
                    $table->string('courier_name')->nullable();
                }
                if (!Schema::hasColumn('orders', 'courier_consignment_id')) {
                    $table->string('courier_consignment_id')->nullable();
                }
                if (!Schema::hasColumn('orders', 'courier_tracking_code')) {
                    $table->string('courier_tracking_code')->nullable();
                }
                if (!Schema::hasColumn('orders', 'courier_status')) {
                    $table->string('courier_status')->nullable();
                }
                if (!Schema::hasColumn('orders', 'fraud_check_score')) {
                    $table->string('fraud_check_score')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abandoned_carts');

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $columns = ['courier_name', 'courier_consignment_id', 'courier_tracking_code', 'courier_status', 'fraud_check_score'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('orders', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
