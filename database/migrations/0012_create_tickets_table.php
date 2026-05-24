<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('status',50)->default('open');
            $table->string('priority',20)->default('medium');
            $table->unsignedBigInteger('created_by')->nullable()->nullable()->index();
            $table->unsignedBigInteger('assigned_to')->nullable()->nullable()->index();
            $table->unsignedBigInteger('campus_id')->nullable()->nullable()->index();
            $table->string('type',50)->default('other');
            $table->unsignedBigInteger('handler_id')->nullable();
            $table->unsignedBigInteger('parent_ticket_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('tickets'); }
};
