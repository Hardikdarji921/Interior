<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('material_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained();
            $table->foreignId('color_option_id')->nullable()->constrained();
            $table->decimal('price_per_unit', 10, 2); // Final calculated price
            $table->string('unit_type'); // sq_ft, piece, etc.
            $table->integer('min_quantity')->default(1);
            $table->integer('max_quantity')->nullable();
            $table->decimal('bulk_discount_percent', 5, 2)->default(0); // Discount for large orders
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_prices');
    }
};