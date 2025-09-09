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
            $table->foreignIdFor(Circuit::class)->constrained()->onDelete('cascade');
            $table->integer('day_number'); //D1, D2, ...
            $table->string('title');
            $table->longText('description');
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
