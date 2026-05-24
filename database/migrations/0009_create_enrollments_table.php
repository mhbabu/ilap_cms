<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable()->nullable()->index();
            $table->unsignedBigInteger('campus_id')->nullable()->nullable()->index();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('module_id')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->string('status',50)->default('enrolled');
            $table->text('notes')->nullable();
            $table->boolean('approved_by_hq')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('enrollments'); }
};
