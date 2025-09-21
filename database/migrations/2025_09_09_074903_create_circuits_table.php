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
        Schema::create('circuits', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('duration')->nullable()->default(0);
            $table->string('start');
            $table->string('end');
            $table->integer('distance');
            $table->boolean('truck_disponibility')->default(false);
            $table->integer('price_3_pers')->default(0);
            $table->integer('price_6_pers')->default(0);
            $table->integer('price_max_pers')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circuits');
    }
};
