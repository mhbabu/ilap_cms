<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('campus_id')->nullable()->index();
            $table->string('source', 200)->nullable();
            $table->unsignedBigInteger('handler_id')->nullable()->index();
            $table->text('notes')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->boolean('is_flag')->default(false);
            $table->string('status',50)->default('new');
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('leads'); }
};
