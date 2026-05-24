<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->nullable()->nullable()->index();
            $table->unsignedBigInteger('receiver_id')->nullable()->nullable()->index();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->string('type',50)->default('internal');
            $table->boolean('is_read')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('messages'); }
};
