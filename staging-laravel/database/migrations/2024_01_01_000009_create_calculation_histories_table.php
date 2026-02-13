<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calculation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained(); // For logged-in users
            $table->string('session_id')->nullable(); // For guests
            $table->foreignId('material_id')->constrained();
            $table->foreignId('color_option_id')->nullable()->constrained();
            $table->decimal('quantity', 10, 2); // Area in sq ft or number of pieces
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->json('breakdown')->nullable(); // Detailed calculation steps
            $table->string('project_name')->nullable(); // User can save calculations
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calculation_histories');
    }
};