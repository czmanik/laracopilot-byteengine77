<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['zizkovska_noc', 'mezidvorky']);
            $table->text('description')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('primary_color', 10)->default('#e11d48');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};