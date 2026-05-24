<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('campus_id')->nullable()->index();
            $table->unsignedBigInteger('handler_id')->nullable()->index();
            $table->date('enrollment_date')->nullable();
            $table->string('current_step',50)->default('registered');
            $table->string('status',50)->default('active');
            $table->string('lead_source',100)->nullable();
            $table->decimal('ielts_score',3,1)->nullable();
            $table->string('passport_number',50)->nullable();
            $table->string('qualification',100)->nullable();
            $table->string('unique_id')->nullable();
            $table->string('enrollment_type',100)->nullable();
            $table->boolean('is_pro')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('students'); }
};
