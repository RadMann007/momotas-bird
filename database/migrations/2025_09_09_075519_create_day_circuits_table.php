<?php

use App\Models\Circuit;
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
        Schema::create('day_circuits', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('day')->unique();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('hotel_name')->nullable();
            $table->string('hotel_description')->nullable();
            $table->longText('description');
            $table->string('image')->nullable();
            $table->integer('distance')->nullable();
            $table->foreignIdFor(Circuit::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_circuits');
    }
};
