<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('filename')->nullable();
            $table->string('original_name')->nullable();
            $table->string('path');
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable()->nullable()->index();
            $table->unsignedBigInteger('campus_id')->nullable()->nullable()->index();
            $table->unsignedBigInteger('student_id')->nullable()->nullable()->index();
            $table->string('type',50)->default('other');
            $table->boolean('is_guide_document')->default(false);
            $table->boolean('is_template')->default(false);
            $table->boolean('broadcast_sent')->default(false);
            $table->timestamp('broadcast_at')->nullable();
            $table->timestamp('ce_requested_at')->nullable();
            $table->string('ce_status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('documents'); }
};
