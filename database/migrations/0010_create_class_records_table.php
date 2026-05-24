<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('class_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('module_id')->nullable();
            $table->string('topic')->nullable();
            $table->decimal('grade', 4, 1)->nullable();
            $table->boolean('attendance')->default(true);
            $table->text('notes')->nullable();
            $table->date('record_date')->nullable();
            $table->text('auto_transcript')->nullable();
            $table->boolean('transcript_generated')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('class_records'); }
};
