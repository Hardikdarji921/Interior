<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('color_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('material_categories');
            $table->string('name'); // Royal Blue, Crimson Red, etc.
            $table->string('hex_code'); // #FF5733
            $table->string('color_code')->nullable(); // Internal code
            $table->decimal('price_multiplier', 5, 2)->default(1.00); // 1.0 = base price, 1.2 = 20% extra
            $table->decimal('fixed_price', 10, 2)->nullable(); // If not using multiplier
            $table->string('finish_type')->nullable(); // Matte, Glossy, Satin
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('color_options');
    }
};