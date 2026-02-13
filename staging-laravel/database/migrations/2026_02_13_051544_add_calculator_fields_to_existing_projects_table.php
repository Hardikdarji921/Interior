<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            // Add only if columns don't exist
            if (!Schema::hasColumn('projects', 'client_name')) {
                $table->string('client_name')->nullable()->after('description');
            }
            if (!Schema::hasColumn('projects', 'client_email')) {
                $table->string('client_email')->nullable();
            }
            if (!Schema::hasColumn('projects', 'client_phone')) {
                $table->string('client_phone')->nullable();
            }
            if (!Schema::hasColumn('projects', 'project_address')) {
                $table->text('project_address')->nullable();
            }
            if (!Schema::hasColumn('projects', 'status')) {
                $table->string('status')->default('draft')->after('project_address');
            }
            if (!Schema::hasColumn('projects', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0);
                $table->decimal('tax_amount', 12, 2)->default(0);
                $table->decimal('discount_amount', 12, 2)->default(0);
                $table->decimal('total_amount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('projects', 'coupon_id')) {
                $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            }
            if (!Schema::hasColumn('projects', 'valid_until')) {
                $table->timestamp('valid_until')->nullable();
            }
            if (!Schema::hasColumn('projects', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $columns = ['client_name', 'client_email', 'client_phone', 'project_address', 
                       'status', 'subtotal', 'tax_amount', 'discount_amount', 'total_amount',
                       'coupon_id', 'valid_until', 'notes'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('projects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};